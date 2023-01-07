<?php

namespace App\Form;

use App\Entity\Single;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddPisteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('piste', EntityType::class, [
                'class' => Single::class,
                'label'=> 'Ajouter un son ',
                    'attr'=>[
                    'class'=>'form-select'
                ],
                'label_attr'=>[
                    'class'=>'form-label'
                ],
                'choice_label' => 'titre',
                'multiple' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.titre', 'ASC');
                },
            ])
            // ...
        ;
    }

    // ...
}
