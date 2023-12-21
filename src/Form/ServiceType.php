<?php

namespace App\Form;

use App\Entity\Service;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', null, [ 'attr' => [
                'class' => 'form-control',
            ],
            ])
            ->add('description', null, [ 'attr' => [
                'class' => 'form-control',
            ],
            ])
            ->add('quantity', null, [ 'attr' => [
                'class' => 'form-control',
            ],
            ])
            ->add('price', null, [ 'attr' => [
                'class' => 'form-control',
            ],
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
