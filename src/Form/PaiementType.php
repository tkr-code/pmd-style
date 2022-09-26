<?php

namespace App\Form;

use App\Entity\Paiement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaiementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('datePaiement', DateType::class, ['widget' => 'single_text'])
            ->add(
                'montantTotal',
                IntegerType::class,
                [
                    'required' => true,
                    'attr' => ['readonly' => true]
                ]
            )
            ->add('montantVerse', IntegerType::class, ['required' => true])
            ->add(
                'montantDu',
                IntegerType::class,
                [
                    'required' => true,
                    'attr' =>
                    [
                        'readonly' => true
                    ]
                ]
            )
           // ->add('estAcheve')
            ->add(
                'modePaiement',
                ChoiceType::class,
                [
                    'placeholder' => 'Choisissez le Mode de Paiement',
                    'choices' =>
                    [
                        'Espèce' => 'Espèce',
                        'Chèque' => 'Chèque',
                        'Orange Money' => "Orange Money",
                        'Wave' => 'Wave'
                    ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Paiement::class,
        ]);
    }
}
