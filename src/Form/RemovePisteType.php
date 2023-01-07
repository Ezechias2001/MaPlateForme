<?php

namespace App\Form;

use App\Entity\Single;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RemovePisteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('piste', EntityType::class, [
                'expanded'=> false,
                'class' => Single::class,
                'multiple' => true,
                'label'=> 'Retirer un son ',
                'attr'=>[
                'class'=>'form-select'
                ],
                'label_attr'=>[
                    'class'=>'form-label'
                ],
            ])
            // ...
        ;
    }

    // ...
}
