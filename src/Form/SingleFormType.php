<?php

namespace App\Form;

use App\Entity\Single;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class SingleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class,[
                    'attr'=>[
                        'class'=>'form-control'
                    ],
                    'label_attr'=>[
                        'class'=>'form-label'
                    ]
                ]
            )
            ->add('uploadPhoto', FileType::class,[
                'label'=>'Image',
                'mapped'=> false,
                'required'=> false,
                'constraints'=>[
                    new File([
                        'maxSize'=>'10m',
                        'mimeTypes'=>[
                            'image/jpg',
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage'=> 'Uploadez une image valide'
                    ])
                ],
                'attr'=>[
                    'class'=>'form-control'
                ],
                'label_attr'=>[
                    'class'=>'form-label'
                ]
            ])
            ->add('uploadSon', FileType::class,[
                'label'=>'Fichier audio',
                'mapped'=> false,
                'required'=> false,
                'constraints'=>[
                    new File([
                        //'maxSize'=>'50m',
                        'mimeTypes'=>[
                            'audio/mpeg'
                        ],
                        'mimeTypesMessage'=> 'Uploadez une fichier valide de moins de 50 mo'
                    ])
                ],
                'attr'=>[
                    'class'=>'form-control'
                ],
                'label_attr'=>[
                    'class'=>'form-label'
                ]
            ])
            ->add('prix', IntegerType::class,[
                'attr'=>[
                    'class'=>'form-control'
                ],
                'label_attr'=>[
                    'class'=>'form-label'
                ]
            ]) /**
            ->add('Auth', EntityType::class,[
                'class'=> User::class,
                'mapped'=>false,
                'attr'=>[
                    'class'=>'form-control'
                ],
                'label_attr'=>[
                    'class'=>'form-label'
                ]
            ]) */
            ->add('Creer', SubmitType::class,[
                'attr'=>[
                    'class'=>'btn btn-success mt-3'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Single::class,
        ]);
    }
}
