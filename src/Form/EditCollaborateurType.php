<?php

namespace App\Form;

use App\Entity\EditCollaborateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EditCollaborateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('adresse', TextType::class)
            ->add('phone', TextType::class)
            ->add('Titre', TextType::class)
            ->add('email', EmailType::class)
            ->add('avatar', FileType::class, ['required' => false])
            ->add('apport', TextType::class)
            ->add(
                'niveauExcellence',
                ChoiceType::class,
                [
                    'choices' =>
                    [
                        '10' => 10,
                        '20' => 20,
                        '30' => 30,
                        '40' => 40,
                        '50' => 50,
                        '60' => 60,
                        '70' => 70,
                        '80' => 80,
                        '90' => 90,
                        '100' => 100
                    ],
                    'placeholder' => 'selectionner un niveau',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => true
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=>EditCollaborateur::class
        ]);
    }
}
