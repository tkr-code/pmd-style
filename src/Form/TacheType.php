<?php

namespace App\Form;

use App\Entity\Tache;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TacheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('designation')
            ->add('description')
            ->add(
                'etat',
                ChoiceType::class,
                [
                    'choices' =>
                    [
                        'Achevée' => "Achevée",
                        'Encours' => 'Encours',
                        'Annulée' => 'Annulée'
                    ],
                    'placeholder'=>"choisir l'état de la tache"
                ]
            )
            ->add('dateAchevement', DateType::class, ['widget' => 'single_text']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tache::class,
        ]);
    }
}
