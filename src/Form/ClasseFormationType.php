<?php

namespace App\Form;

use App\Entity\ClasseFormation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClasseFormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('designation', TextType::class)
            ->add(
                'niveauEtude',
                ChoiceType::class,
                [
                    'choices' =>
                    [
                        '1 ere année' => 'L1',
                        '2 ème année' => 'L2',
                        '3 ème année' => 'L3',
                        '4 ème année' => 'M1',
                        '5 ème année' => 'M2',
                        '6 ème année' => 'Doctorat 1',
                        '7 ème année' => 'Doctorat 2',
                        '8 ème année' => 'Doctorat 3',

                    ],
                    'placeholder'=>'Quel est le niveau d\'étude ?'
                ]
            )
            ->add('nombreEtudiant', IntegerType::class)
            ->add('abreviation')
            // ->add('formationDispensee')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ClasseFormation::class,
        ]);
    }
}
