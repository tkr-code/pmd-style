<?php

namespace App\Form;

use App\Entity\Caisse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use function PHPSTORM_META\map;

class CaisseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code',ChoiceType::class,[
                'choices'=>Caisse::CODE
            ])
            ->add('libelle')
            ->add('montant')
            ->add('type',ChoiceType::class,[
                'choices'=>Caisse::TYPE
            ])
            ->add('is_editable')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Caisse::class,
        ]);
    }
}
