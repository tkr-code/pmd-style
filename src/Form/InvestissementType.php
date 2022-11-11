<?php

namespace App\Form;

use App\Entity\Investissement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvestissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type',TextType::class)
            ->add('designation',TextType::class)
            ->add('description',TextareaType::class)
            ->add('date_debut',DateType::class,['widget'=>'single_text'])
            ->add('date_fin',DateType::class,['widget'=>'single_text'])
            ->add('montantInvestissement',IntegerType::class)
            //->add('contractantInvestissement',ContractantInvestissementType::class)
            //->add('user')
            //->add('contratInvestissement') #on va le remplir en arrière plan
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Investissement::class,
        ]);
    }
}
