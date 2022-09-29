<?php

namespace App\Form;

use App\Form\TacheType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AddTacheCollectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'tache',
                CollectionType::class,
                [
                    'label' => false,
                    'entry_type' => TacheType::class,
                    'entry_options' => ['label' => false],
                    'by_reference' => false,
                    'allow_add' => true, #pour permmetre plusieurs ajouts
                    'allow_delete' => true,
                    //'prototype'=>true,

                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
