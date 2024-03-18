<?php

namespace App\Form;

use App\Entity\Application;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $optionEdit = empty($options['edit']) ? false:true;
        $required = $optionEdit == true ? true:false;
        $builder
            ->add('nom')
            ->add('version')
            ->add('description',TextareaType::class,[
                'attr'=>[

                    'class'=>'text_area_summernote'
                ]
            ]);
            if($optionEdit){
                $builder->add('logo',FileType::class,[
                    'label'=>'Ajouter le logo (*)',
                    'multiple'=>false,
                    'mapped'=>false,
                    'required'=>$required,
                    'constraints'=>[],
                ]);
            }
            $builder
            ->add('images',FileType::class,[
                'label'=>'Ajouter une ou plusieurs images (*)',
                'multiple'=>true,
                'mapped'=>false,
                'required'=>$required,
                'constraints'=>[],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Application::class,
        ]);
    }
}
