<?php

namespace App\Form;

use App\Entity\ClientRDV;
use App\Entity\EditClientRDV;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditClientRDVType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('societe', TextType::class)
            ->add('ville', TextType::class)
            ->add('pays', TextType::class)
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('adresse', TextType::class)
            ->add('phone', TextType::class)
            ->add('titre', TextType::class)
            ->add('email', TextType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EditClientRDV::class,
        ]);
    }
}
