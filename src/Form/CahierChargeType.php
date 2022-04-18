<?php

namespace App\Form;

use App\Entity\CahierCharge;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CahierChargeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number',TextType::class,[
                'attr'=>[
                    'disabled'=>true
                ]
            ])
            ->add('fullName')
            ->add('email')
            ->add('tel')
            ->add('status',ChoiceType::class,[
                'choices'=>CahierCharge::status
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CahierCharge::class,
        ]);
    }
}
