<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\ChangePasswordType;

class AccountPasswordController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/compte/changer-mot-de-passe", name="account_password")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {   
        $notification = null;

        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request) ;

        if($form->isSubmitted() && $form->isValid()){
            $old_pw = $form->get('old_password')->getData();
            if ($encoder->isPasswordValid($user,$old_pw)){
                $new_pw = $form->get('new_password')->getData();
                $password = $encoder->encodePassword($user, $new_pw);
                $user->setPassword($password);
                // $this->entityManager->persist uniquement pour la creation, 
                // inutile pour les updates
                $this->entityManager->flush();
                $notification = "Votre mot de passe a bien ete mis a jour";
            }
            else{
                $notification = "Votre mot de passe actuel n'est pas valide";
            }
        }

        return $this->render('account/password.html.twig',[
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
}
