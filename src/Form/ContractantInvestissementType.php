<?php

namespace App\Form;

use App\Entity\ContractantInvestissement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContractantInvestissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ville',TextType::class)
            ->add('pays',TextType::class)
            ->add('codePostal',TextType::class)
            ->add('personneGestion',PersonneGestionType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContractantInvestissement::class,
        ]);
    }
}
