<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AddFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('content')
            ->add('date')
            ->add('categoryId', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'Catégories',
                'placeholder' => 'Choisissez votre catégorie : '
            ])
            ->add('visibility', ChoiceType::class, [
                'label' => 'Privé',
                'choices' => [
                    'Oui' => false,
                    'Non' => true
                ],
                'multiple' => false,
                'expanded' => true
            ])
            ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
