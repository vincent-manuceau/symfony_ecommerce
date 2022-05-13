<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\ResetPassword;
use App\Entity\User;
use App\Form\ResetPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResetPasswordController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/mot-de-passe-oublie", name="reset_password")
     */
    public function index(Request $request): Response
    {
        if ($this->getUser()){
            $this->addFlash('notice',"Cette adresse e-mail est inconnue");
            return $this->redirectToRoute('home');
        }

        if ($request->get('email')){
            $user = $this->entityManager->getRepository(User::class)->findOneByEmail($request->get('email'));
            if ($user){
                // Enregistrer la demande de reset en base
                $resetPassword = new ResetPassword();
                $resetPassword->setUser($user);
                $resetPassword->setToken(uniqid());
                $resetPassword->setCreatedAt(new \DateTime());
                $this->entityManager->persist($resetPassword);
                $this->entityManager->flush();

                // Envoyer un email de reinitialisation
                $url = $this->generateUrl('update_password', ['token' => $resetPassword->getToken()]);

                $content = "Bonjour ".$user->getFirstName().' '.$url."<br/>";
                $content .=   "Vous avez demande une reinitialisation de mot de passe sur la boutique creole.<br/><br/>";
                $content .=    "Merci de bien vouloir cliquer sur le lien suivant pour <a href=\"$url\">mettre votre mot de passe a jour</a>";

                $mail = new Mail();
                $mail->send($user->getEmail(), $user->getFullName(), "Reinitialisez votre mot de passe",
                    $content );
                $this->addFlash('notice',"Consultez votre boite mail, vous allez recevoir dans quelques secondes un e-mail de notre part !");
            }
            else{
                $this->addFlash('notice',"Cette adresse e-mail est inconnue");
            }
        }

        return $this->render('reset_password/index.html.twig');
    }

    /**
     * @Route("modifier-mon-mot-de-passe/{token}", name="update_password")
     */
    public function update(Request $request, $token, UserPasswordEncoderInterface $encoder): Response
    {
        $resetPassword = $this->entityManager->getRepository(ResetPassword::class)->findOneByToken($token);
        if (!$resetPassword){
            return $this->redirectToRoute('reset_password');
        }
        //Verifier si le createdAt = maintenant - 3 heures
        $now = new \DateTime();
        if ($now >= $resetPassword->getCreatedAt()->modify('+ 3 hour')){
            $this->addFlash('notice',"Votre demande de mot de passe a expire, merci de la renouveler");
            return $this->redirectToRoute('reset_password');
        }

        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
           // dd($form->getData());
            $new_pasword = $form->get('password')->getData();

            $encoded_password = $encoder->encodePassword($resetPassword->getUser(), $new_pasword);
            $resetPassword->getUser()->setPassword($encoded_password);

            $this->entityManager->flush();
            $this->addFlash('notice','Votre mot de passe a bien ete mis a jour !');

            return $this->redirectToRoute('app_login');


        }

        return $this->render('reset_password/update.html.twig',[
            'form' => $form->createView()
        ]);

       // return $this->redirectToRoute('app_login');
    }

}
