<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/nous-contacter", name="contact")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->addFlash('notice', "Merci de nous avoir contacte, notre equipe vous recontactera prochainement");

            $fd = $form->getData() ;
            $content = $fd['prenom']." ".$fd['nom']." ".$fd['email']." ".$fd['content'] ;
            //dd($content);
            $mail = new Mail();
            $mail->send('vincent@manuceau.net','Support La Boutique Creole', 'Nouveau Message', $content);
        }

        return $this->render('contact/index.html.twig',[
            'form'=> $form->createView()
        ]);
    }
}
