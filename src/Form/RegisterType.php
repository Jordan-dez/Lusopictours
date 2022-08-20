<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // personalisation des champs du formulaire
        $builder
        ->add('nom',TextType::class,[
            'label' => 'Votre nom',
            'attr'=>[ 'placeholder' =>'Merci de saisir votre nom']
        ])
        ->add('prenom',TextType::class,[
            'label' => 'Votre prenom',
            'attr' => [ 'placeholder' => 'Merci de saisir Prénom']
        ])
        ->add('email',EmailType::class,[
            'label' => 'Votre email',
            'attr' => [ 'placeholder' => 'jean@pictours.com']
        ])
        ->add('password',RepeatedType::class,[
            'type'=>PasswordType::class,
            'invalid_message' => 'le mot de passe et la confirmation doivent être identiques',
            'label' => 'Mot de passe',
            'required' => true,
            'first_options' =>[
                'label' =>"Votre mot de passe",
                'attr' => [ 'placeholder' => 'Merci de saisir votre mot de passe']
            ],
            'second_options' => ['label' =>'Confirmez votre mot de passe','attr' => [ 'placeholder' =>'Merci de confirmer votre mot de passe']]
        ])
        ->add('submit',SubmitType::class,[
            'label' =>"S'inscrire",
            'attr' => [ 'class' =>'btn btn-primary']
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
