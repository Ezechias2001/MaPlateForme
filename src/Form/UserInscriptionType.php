<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserInscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder' => 'nom@exemple.com'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => "Le mot de passe et la confirmation doivent être identiques",
                'required' => true,
                'first_options' => [
                    'attr'=>[
                        'class'=>'form-control',
                        'placeholder' => 'Entrez un mot de passe'
                    ]
                ],
                'second_options' => [
                    'attr'=>[
                        'class'=>'form-control',
                        'placeholder' => 'Confirmer le mot de passe'
                    ]
                ]
            ])
            ->add('nom', TextType::class, [
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder' => 'Entrez votre nom'
                ]
            ])
            ->add('prenom', TextType::class, [
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder' => 'Entrez votre prenom'
                ]
            ])
            ->add('pseudo', TextType::class, [
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder' => 'Entrez un pseudo'
                ]
            ])
            ->add("Soumettre", SubmitType::class,[
                'attr'=>[
                    'class'=>'btn btn-secondary w-100 mb-3'
                ]
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
