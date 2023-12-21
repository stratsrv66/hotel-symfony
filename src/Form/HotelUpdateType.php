<?php

namespace App\Form;

use App\Entity\Hotel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HotelUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', null, [ 'attr' => [
                'class' => 'form-control',
            ],
            ])
            ->add('name', null, [ 'attr' => [
                'class' => 'form-control',
            ],
            ])
            ->add('address', null, [ 'attr' => [
                'class' => 'form-control',
            ] ])
            ->add('submit', SubmitType::class, [ 'attr' => [
                'class' => 'btn btn-primary',
            ],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hotel::class,
        ]);
    }
}
