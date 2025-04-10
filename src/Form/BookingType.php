<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Activity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Validator\Constraints as Assert;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('userName', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => "Le nom d'utilisateur est requis."]),
                ],
            ])
            ->add('bookingTime', DateTimeType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => "La date et l'heure de réservation sont requises."]),
                    new Assert\Type([
                        'type' => \DateTimeInterface::class,
                        'message' => "La date et l'heure doivent être valides.",
                    ]),
                ],
            ])
            ->add('participants', IntegerType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => "Le nombre de participants est requis."]),
                    new Assert\Positive(['message' => "Le nombre de participants doit être supérieur à zéro."]),
                ],
            ])
            ->add('activity', EntityType::class, [
                'class' => Activity::class,
                'choice_label' => 'name',
                'constraints' => [
                    new Assert\NotNull(['message' => "L'activité est requise."]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
