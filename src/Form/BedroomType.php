<?php

namespace App\Form;

use App\Entity\Bedroom;
use App\Entity\Category;
use App\Entity\Hotel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BedroomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number', null, [ 'attr' => [
                'class' => 'form-control',
            ],
            ])
            ->add('type', null, [ 'attr' => [
                'class' => 'form-control',
            ],
            ])
            ->add('hotel_id', EntityType::class, ['attr' => [
                'class' => 'form-control',
            ],
                'class' => Hotel::class,
'choice_label' => 'name',
            ])
            ->add('categories', EntityType::class, [
                'attr' => [
                'class' => 'form-control',
            ],
                'class' => Category::class,
                'choice_label' => 'label',
                'multiple' => true,
            ])
        ->add('submit', SubmitType::class, [ 'attr' => [
            'class' => 'btn btn-primary',
        ],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bedroom::class,
        ]);
    }
}
