<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Publication;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('content')
            ->add('publishedAt')
            ->add('image', FileType::Class, [
                'label' =>'Televerser l\èimage de la publication',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
                
                ])
            ->add('user', EntityType::class, [
                'class' => User::class, // L'entité cible
                'choice_label' => 'lastname', // La propriété à afficher dans les options de sélection
                'label' => 'Author', // Label du champ
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Publication::class,
        ]);
    }
}
