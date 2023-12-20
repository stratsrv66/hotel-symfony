<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', null, [ 'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('password', null, [ 'attr' => [
                'class' => 'form-control',
            ],
            ])
            ->add('email', null, [ 'attr' => [
                'class' => 'form-control',
            ],

            ])
            ->add('phone', null, [ 'attr' => [
                'class' => 'form-control',
            ],
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
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
