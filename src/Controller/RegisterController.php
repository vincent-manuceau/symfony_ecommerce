<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
		private $entityManager;

		public function __construct(EntityManagerInterface $entityManager){
			$this->entityManager = $entityManager;
		}
    /**
     * @Route("/inscription", name="register")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $notification = null;

    	$user = new User();
    	$form = $this->createForm(RegisterType::class, $user);

    	$form->handleRequest($request);

    	if ($form->isSubmitted() && $form->isValid()){
    		$user = $form->getData();

            $search_email = $this->entityManager->getRepository(User::class)->findOneByEmail($user->getEmail());

            if (!$search_email){
                $password = $encoder->encodePassword($user,$user->getPassword());

                $user->setPassword($password);

                $this->entityManager->persist($user);
                $this->entityManager->flush() ;

                $mail = new Mail();
                $content = "Bonjour ".$user->getFirstname()."<br/>Bienvenue sur la premiere boutique 100% creole !";
                $mail->send($user->getEmail(), $user->getFirstname(), "Bienvenue sur la Boutique creole !", $content);

                $notification = "Votre inscription s'est correctement deroulee, vous pouvez des a present vous connecter a votre compte";

            }else{
                $notification = "L'email existe deja dans notre base de donnees";
            }





         //   return $this->redirectToRoute('account');

    	}

      return $this->render('register/index.html.twig', [
        'form' => $form->createView(),
        'notification' => $notification
      ]);
    }
}
