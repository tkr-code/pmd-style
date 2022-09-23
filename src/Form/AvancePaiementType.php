<?php

namespace App\Form;

use App\Entity\AvancePaiement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AvancePaiementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateCreation')
            ->add('dateAvance')
            ->add('montantAvance')
            ->add('montantDu')
            ->add('estAtteint')
            ->add('modePaiementAvance')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AvancePaiement::class,
        ]);
    }
}
