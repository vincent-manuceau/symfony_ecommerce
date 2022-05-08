<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'disabled' => true,
                'label' => "Mon adresse e-mail"
            ])     
            ->add('firstname', TextType::class, [
                'disabled' => true,
                'label' => "Mon prenom"
            ])
            ->add('lastname', TextType::class, [
                'disabled' => true,
                'label' => "Mon nom"
            ])
            ->add('old_password', PasswordType::class, [
                'label' => "Mon mot de passe actuel",
                'mapped' => false,
                'attr' => [
                    'placeholder' => "Saisissez votre mot de passe actuel"
                ]
            ])
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'le mot de passe et la confirmation doivent etre identiques',
                'required' => true,
                'first_options' => [
                    'label' => "Mon nouveau mot de passe",
                    'attr' => ["placeholder" => "Merci de saisir votre nouveau mot de passe"]
                ],
                'second_options' => [
                    'label' => "Confirmez votre nouveau mot de passe",
                    'attr' => ['placeholder' => "Merci de confirmer votre nouveau mot de passe"]
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Changer"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
