<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Classe\Mail;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderSuccessController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/commande/merci/{stripeSessionId}", name="order_success")
     */
    public function index(Cart $cart, $stripeSessionId): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        if (!$order || $order->getUser() != $this->getUser()){
            return $this->redirectToRoute('home');
        }

        if($order->getState() == 0){
            //Vider le panier
            $cart->remove();

            //Modifier le status isPaid a 1
            $order->setState(1);
            $this->entityManager->flush();

            //Envoyer un mail de confirmation au client
            $mail = new Mail();
            $content = "Bonjour ".$order->getUser()->getFirstname()."<br/>Merci pour votre commande ! Nous allons la preparer rapidement !";
            $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstname(), "Votre commande La Boutique Creole est bien validee !", $content);
        }

        //Afficher un resume de la commande de l'utilisateur

        return $this->render('order/success.html.twig',[
            'order' => $order
        ]);
    }
}
