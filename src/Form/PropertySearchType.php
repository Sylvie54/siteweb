<?php

namespace App\Form;

use App\Entity\PropertySearch;
use App\Entity\Option;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class PropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            
            
        ->add('minSurface', IntegerType::class,  [
            'required' => false,
            'label' => false,
            'attr' => [
                'placeHolder' => 'Surface minimale'
            ]
        ])
        ->add('maxPrice', IntegerType::class,  [
            'required' => false,
            'label' => false,
            'attr' => [
                'placeHolder' => 'Budget maximal'
            ]
        ])

        ->add('options', EntityType::class, [
            'class' => Option::class,
                'required' => false,
                'label' => false,
                'choice_label' => 'name',
                'multiple' => true
        ])      

             /*  ->add('submit', SubmitType::class, [
                    'label' => 'Rechercher'    
                ]) */
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }
    // pour qu'il y ai minSurface et maxPrice comme paramètres GET 
    public function getBlockPrefix()
    {
       return '' ;
    }
}
