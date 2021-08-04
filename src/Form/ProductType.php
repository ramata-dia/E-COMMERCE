<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Categories;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('image', FileType::class,[
                 'label' => 'image (PDF file)',
                  'mapped' => false,
                   'required' => false,
                    
            
            ])
            ->add('price')
            ->add('description', TextType::class)
            ->add('quantity', TextType::class)
            ->add('categories', EntityType::class, [
    // looks for choices from this entity
    'class' => Categories::class,

    // uses the User.username property as the visible option string
    'label' => false,
    'choice_label' => 'nom',

    'attr'  => [
        'class'   => 'form-control',
    ],

           'required'  => false,
    ])



              ->add('save', SubmitType::class, ['label' => 'Ajouter']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
