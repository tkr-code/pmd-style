<?php

namespace App\Form;

use App\Entity\Amelioration;
use App\Entity\Application;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AmeliorationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('application', EntityType::class, [
                'class' => Application::class,
                'attr' => [
                    'class' => 'select2'
                ],
                'choice_label' => 'nom',
                'placeholder' => "Selectionner une application"
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Type',
                'choices' => Amelioration::TYPE,
                'placeholder' => "Selectionner un type",
                'attr' => [
                    'class' => 'select2'
                ]
            ])
            ->add('description');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Amelioration::class,
        ]);
    }
}
