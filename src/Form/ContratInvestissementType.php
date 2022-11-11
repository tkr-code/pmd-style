<?php

namespace App\Form;

use App\Entity\ContratInvestissement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContratInvestissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('designation')
            ->add('date_creation')
            ->add('date_debut')
            ->add('date_echeance')
            ->add('numero_contrat')
            ->add('investissement')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContratInvestissement::class,
        ]);
    }
}
