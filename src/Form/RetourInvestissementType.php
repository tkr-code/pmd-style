<?php

namespace App\Form;

use App\Entity\RetourInvestissement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RetourInvestissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('montant_recu', IntegerType::class)
            ->add('date_reception', DateType::class, ['widget' => 'single_text'])
            //->add('estRecuperer') #on le geère en arrière plan
            //->add('investissement')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RetourInvestissement::class,
        ]);
    }
}
