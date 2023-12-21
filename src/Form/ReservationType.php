<?php

namespace App\Form;

use App\Entity\Bedroom;
use App\Entity\Reservation;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('start_date', null, [ 'attr' => [
                'class' => 'form-control',
            ],
            ])
            ->add('end_date', null, [ 'attr' => [
                'class' => 'form-control',
            ],
            ])
            ->add('bedroom_id', EntityType::class, [
                 'attr' => [
                    'class' => 'form-control',
                ],
                'class' => Bedroom::class,
'choice_label' => 'id',
            ])
            ->add('user_id', EntityType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'class' => User::class,
'choice_label' => 'username',
            ])->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
