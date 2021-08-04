<?php

namespace App\Form;
use App\Entity\Categories;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mots' , SearchType::class, [
                'label'  =>  false,
                'attr'   =>  [
                    'class'  =>  'form-control',
                    'placeholder'  =>  'Un ou plusieurs mots clés',
                ]
            ])
        
       ->add('Rechercher' , SubmitType::class ,
       [
            'attr' => [
                'class' => 'btn primary'
            ]
            ])
         
       ->add('Categories' , EntityType::class , [
           'class' => Categories::class,
           'label' =>  false,
           'attr' => [
               'class' => 'form-control',
           ]
       ]);  
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
