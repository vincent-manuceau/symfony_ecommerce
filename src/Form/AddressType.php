<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label' => 'Quel nom souhaitez-vous donner a votre adresse ?',
                'attr' => [
                    'placeholder' => 'Nommez votre adresse'
                ]
            ])
            ->add('firstname', TextType::class,[
                'label' => 'Votre prenom',
                'attr' => [
                    'placeholder' => 'Entrez votre prenom'
                ]
            ])
            ->add('lastname', TextType::class,[
                'label' => 'Votre nom',
                'attr' => [
                    'placeholder' => 'Entrez votre nom'
                ]
            ])
            ->add('company', TextType::class,[
                'label' => 'Votre societe (optionnel)',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Entrez le nom de votre societe'
                ]
            ])
            ->add('address', TextType::class,[
                'label' => 'Votre adresse',
                'attr' => [
                    'placeholder' => '17 rue alphone daudet '
                ]
            ])
            ->add('postal', TextType::class,[
                'label' => 'Code Postal',
                'attr' => [
                    'placeholder' => '75014'
                ]
            ])
            ->add('city', TextType::class,[
                'label' => 'Ville',
                'attr' => [
                    'placeholder' => 'Paris'
                ]
            ])
            ->add('country', CountryType::class,[
                'label' => 'Votre Pays',
                'attr' => [
                    'placeholder' => 'France'
                ]
            ])
            ->add('phone', TelType::class,[
                'label' => 'Votre telephone',
                'attr' => [
                    'placeholder' => 'Entrez votre telephone'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn-block btn-info'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
