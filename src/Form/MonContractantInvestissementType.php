<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use App\Entity\ContractantInvestissement;
use App\Entity\MonContratInvestissement;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MonContractantInvestissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ville', TextType::class)
            ->add('pays', TextType::class)
            ->add('codePostal', TextType::class)
            ->add('nom',TextType::class)
            ->add('prenom',TextType::class)
            ->add('adresse',TextType::class)
            ->add('phone',TextType::class)
            ->add('titre',TextType::class)
            ->add('email',TextType::class)
            ->add('avatar',FileType::class,['required'=>false])
            ->add('type', TextType::class)
            ->add('designation', TextType::class)
            ->add('description', TextareaType::class)
            ->add('date_debut', DateType::class, ['widget' => 'single_text'])
            ->add('dateFin', DateType::class, ['widget' => 'single_text'])
            ->add('montantInvestissement', IntegerType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MonContratInvestissement::class
        ]);
    }
}
