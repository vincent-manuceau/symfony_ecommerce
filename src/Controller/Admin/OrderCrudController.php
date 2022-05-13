<?php

namespace App\Controller\Admin;

use App\Classe\Mail;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;

class OrderCrudController extends AbstractCrudController
{
    private $entityManager;
    private $adminUrlGenerator;

    public function __construct(EntityManagerInterface $entityManager,  AdminUrlGenerator $adminUrlGenerator){
        $this->entityManager  = $entityManager;
        $this->adminUrlGenerator = $adminUrlGenerator ;
    }

    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $updatePreparation = Action::new('updatePreparation', 'Preparation en cours', "fas fa-box-open")
            ->linkToCrudAction('updatePreparation') ;
        $updateDelivery = Action::new('updateDelivery', 'Livraison en cours', 'fas fa-truck')
            ->linkToCrudAction('updateDelivery') ;
        return $actions
            ->add('detail', $updatePreparation)
            ->add('detail', $updateDelivery)
            ->add('index',  'detail');
    }

    public function updatePreparation(AdminContext $context) : Response
    {
        $order = $context->getEntity()->getInstance();
        $order->setState(2);
        $this->entityManager->flush();

        $this->addFlash('notice', "<span style='color:green'><strong>La commande ".
            $order->getReference().
            " est bien <u>en cours de preparation</u></strong></span>");


        $url = $this->adminUrlGenerator
            ->setController(OrderCrudController::class)
            ->setAction('index')
            ->generateUrl();

        $mail = new Mail();
        $mail->send($order->getUser()->getEmail(), $order->getUser()->getFullname(), "Votre commande est en cours de preparation",
        "En cours de preparation !!!");

        return $this->redirect($url);
    }

    public function updateDelivery(AdminContext $context) : Response
    {
        $order = $context->getEntity()->getInstance();
        $order->setState(3);
        $this->entityManager->flush();

        $this->addFlash('notice', "<span style='color:orange'><strong>La commande ".
            $order->getReference().
            " est bien <u>en cours de livraison</u></strong></span>");


        $url = $this->adminUrlGenerator
            ->setController(OrderCrudController::class)
            ->setAction('index')
            ->generateUrl();

        return $this->redirect($url);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setDefaultSort(['id'=> 'DESC']);
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            DateTimeField::new('createdAt', 'Commande du'),
            TextField::new('user.fullname', 'Client'),
            TextareaField::new('delivery', 'Addresse de livraison')->renderAsHtml()->onlyOnDetail(),
            MoneyField::new('total', 'Total produits')->setCurrency('EUR'),
            TextField::new('carrierName', 'Client'),
            MoneyField::new('carrierPrice', 'Frais de port')->setCurrency('EUR'),
            ChoiceField::new('state')->setChoices([
                'Non payee' => 0,
                'Paiement OK' => 1,
                'Preparation en cours' => 2,
                'Livraison en cours' =>3
            ]),
            ArrayField::new('orderDetails', 'Produits achetes')->hideOnIndex()

        ];
    }

}
