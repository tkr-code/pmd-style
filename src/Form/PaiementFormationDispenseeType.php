<?php

namespace App\Form;

use App\Entity\PaiementFormationDispensee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaiementFormationDispenseeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('datePaiement')
            ->add('montant')
            ->add('formationDispensee')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PaiementFormationDispensee::class,
        ]);
    }
}
