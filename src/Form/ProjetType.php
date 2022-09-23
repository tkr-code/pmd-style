<?php

namespace App\Form;

use App\Entity\Projet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('designation',TextType::class,['required'=>true])
            ->add('description',TextType::class,['required'=>true])
            ->add('type',TextType::class,['required'=>true])
            ->add('valeurTotal',IntegerType::class,['required'=>true])
            ->add('dateDebut', DateType::class, ['widget' => 'single_text'])
            ->add('dateFinPrevu', DateType::class, ['widget' => 'single_text'])
           // ->add('dateFinRealisation', DateType::class, ['widget' => 'single_text'])
            ->add(
                'etat',
                ChoiceType::class,
                [
                    'choices' => [
                        'Encours' => 'Encours',
                        'Annuler' => 'Annuler',
                        'Suspendu'=>'Suspendu',
                        'Achevé' => 'Achevé'
                    ],
                    'placeholder'=>'Choisir L\'etat',
                    'required'=>true
                ]
            )
            ->add(
                'client',
                ClientType::class,
                [
                    'label' => false
                ]
            )
            ->add(
                'paiement',
                PaiementType::class,
                [
                    'label' => false
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}
