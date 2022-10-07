<?php

namespace App\Form;

use App\Entity\Pointage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PointageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombreHeureDispense')
            ->add('contenuDispense')
            ->add('datePointage')
            ->add('esSupplementaire')
            ->add('formationDispensee')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pointage::class,
        ]);
    }
}
