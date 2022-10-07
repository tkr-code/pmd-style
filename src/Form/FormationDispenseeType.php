<?php

namespace App\Form;

use App\Entity\FormationDispensee;
use App\Entity\Module;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormationDispenseeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('volumeHoraire')
            ->add('valeurHeure')
           /*  ->add(
                'etat',
                ChoiceType::class,
                [
                    'choices' =>
                    [
                        'En Cour' => 'En Cour',
                        'Annuler' => 'Annulé',
                        'Suspendu' => 'Suspendu',
                    ],
                    'placeholder'=>'Quel est l\'etat du cour ? '
                ]
            ) */
            ->add('dateDebut', DateType::class, ['widget' => 'single_text'])
           // ->add('dateFin', DateType::class, ['widget' => 'single_text'])
            ->add(
                'module',
                EntityType::class,
                [
                    'class' => Module::class,
                    'choice_label' => 'abreviation',
                    'placeholder' => 'veuillez choisir un Module'
                ]
            )
            ->add(
                'classe',
                ClasseFormationType::class,
                ['mapped' => false]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FormationDispensee::class,
        ]);
    }
}
