<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('type')
            ->add('image', FileType::class, [
                'mapped' => false,
                'label' => 'Titre de l\'article',
                'attr' => [
                'class' => 'form-control mb-3'
                ]
                ])
            ->add('price')
            ->add('description')
            ->add('category', EntityType::class, [
                'class' => 'App\Entity\Category', // L'entité de la catégorie
                'choice_label' => 'name', // Le champ à afficher (nom de la catégorie)
                'placeholder' => 'Sélectionner une catégorie', // Texte par défaut
                'required' => true, // La catégorie est-elle requise ?
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
