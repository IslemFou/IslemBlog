<?php

namespace App\Form;

use App\Entity\Users;
use App\Entity\Profil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'votre Prénom',
                'attr' => ['placeholder' => 'Merci de saisir votre prénom'],
                //faire des contraintes
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'max' => 100,
                        'minMessage' => 'Le prénom doit comporter au moins {{ limit }} caractères',
                        'maxMessage' => 'Le prénom doit comporter au plus {{ limit }} caractères',
                    ])
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => 'votre Nom',
                'attr' => ['placeholder' => 'Merci de saisir votre Nom'],
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'max' => 100,
                        'minMessage' => 'Le prénom doit comporter au moins {{ limit }} caractères',
                        'maxMessage' => 'Le prénom doit comporter au plus {{ limit }} caractères',
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'votre Email',
                'attr' => ['placeholder' => 'Email@email.com'],
                // 'constraints' => []
            ])
            // ->add('roles')
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de Passe',
                    'attr' => ['placeholder' => 'Mot de Passe'],
                    'constraints' => [
                        new Length([
                            'min' => 8,
                            'max' => 14,
                            'minMessage' => 'Le mot de passe doit comporter au moins {{ limit }} caractères',
                            'maxMessage' => 'Le mot de passe doit comporter au plus {{ limit }} caractères',
                        ])
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmez votre mot de Passe',
                    'attr' => ['placeholder' => 'Confirmer votre mot de Passe'],
                    'constraints' => [
                        new Length([
                            'min' => 8,
                            'max' => 14,
                            'minMessage' => 'Le mot de passe doit comporter au moins {{ limit }} caractères',
                            'maxMessage' => 'Le mot de passe doit comporter au plus {{ limit }} caractères',
                        ])
                    ]
                ]



            ])
            // ->add('profill', EntityType::class, [
            //     'class' => Profil::class,
            //     'choice_label' => 'id',
            // ])
            ->add('submit', SubmitType::class, [
                'label' => 'S\'inscrire',

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
