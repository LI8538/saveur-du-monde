<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'attr' => ['placeholder' => 'Votre nom'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir votre nom']),
                    ]]);
            ->add('phone', TelType::class, [
                'required' => true,
                'attr' => ['placeholder' => 'Votre téléphone'],
                'constraints' => [
                    new Length([
                        'min' => 10,
                        'minMessage' => 'Votre numéro de téléphone doit contenir au moins {{ limit }} caractères',
                        'max' => 15,
                        'maxMessage' => 'Votre numéro de téléphone doit contenir au maximum {{ limit }} caractères',
                    ]),
                ]
            ]) // Terminé
            ->add('mail')
            ->add('date')
            ->add('numberPerson')
            ->add('message')
            ->add('isConfirm')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
