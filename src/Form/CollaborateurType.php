<?php

namespace App\Form;

use App\Entity\Collaborateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CollaborateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('personneGestion', PersonneGestionType::class, ['label' => false])
            ->add('apport')
            ->add(
                'niveauExcellence',
                ChoiceType::class,
                [
                    'choices' =>
                    [
                        '10' => 10,
                        '20' => 20,
                        '30' => 30,
                        '40' => 40,
                        '50' => 50,
                        '60' => 60,
                        '70' => 70,
                        '80' => 80,
                        '90' => 90,
                        '100' => 100
                    ],
                    'placeholder' => 'selectionner un niveau',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => true
                ]
            )
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
            'data_class' => Collaborateur::class,
        ]);
    }
}
