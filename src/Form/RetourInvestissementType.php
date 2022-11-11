<?php

namespace App\Form;

use App\Entity\RetourInvestissement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RetourInvestissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('montant_recu')
            ->add('date_reception')
            ->add('estRecuperer')
            ->add('investissement')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RetourInvestissement::class,
        ]);
    }
}
