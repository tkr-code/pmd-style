<?php

namespace App\Form;

use App\Entity\FormationOption;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormationOptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('contenu',TextareaType::class,[
                'attr'=>[

                    'class'=>'text_area_summernote'
                ]
                ],
                
            )
            ->add('is_active',CheckboxType::class,[
                'label'=>'Es Visible ?',
                'required'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FormationOption::class,
        ]);
    }
}
