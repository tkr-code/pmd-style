<?php

namespace App\Form;

use App\Entity\PaiementFormationDispensee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaiementFormationDispenseeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('datePaiement', DateType::class, ['widget' => 'single_text'])
            ->add('montant',IntegerType::class)
            ->add(
                'justification',
                ChoiceType::class,
                [
                    'choices' =>
                    [
                        'Enseignement suspendu' => 'Enseignement suspendu',
                        'Cour Achevé' => 'Cour Achevé',
                        'Autres'=>'Non Précisée'
                    ],
                    'placeholder'=>'choisir la justification'
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PaiementFormationDispensee::class,
        ]);
    }
}
