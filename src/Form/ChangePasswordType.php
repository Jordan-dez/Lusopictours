<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                'label' => 'Votre adresse email',
                'disabled' => true,
            ])
            ->add('nom',TextType::class,[
                'label' => 'Votre Nom',
                'disabled' => true,
            ])
            ->add('prenom',TextType::class,[
                'label' => 'Votre Prenom',
                'disabled' => true,
            ])
            ->add('old_password',PasswordType::class,[
                'label' => 'Saisissez votre ancien mot de passe',
                'mapped' => false,
                'required' => true,
                'attr' => ['placeholder'=>'Veillez saisir votre mot de passe actuel'],
            ])
            ->add('new_password',RepeatedType::class,[
                'type' =>PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'le mot de passe et la confirmation doivent être identiques',
                'label' => 'Mon nouveau mot de passe',
                'required' => true,
                'first_options' => [
                    'label' => 'Votre nouveau mot de passe',
                    'attr' => ['placeholder' => 'merci de saisir votre nouveau mot de passe'],
            ],
                'second_options' => ['label' => 'Confirmez votre nouveau mot de passe','attr' => ['placeholder' => 'merci de Confirmer votre nouveau mot de passe'],]
            ])
            ->add('submit',SubmitType::class,[
                'label' => 'sauvegarder'
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
