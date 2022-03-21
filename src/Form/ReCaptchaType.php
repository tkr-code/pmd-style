<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReCaptchaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->vars['type'] = $options['type'];
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        
        $resolver->setDefault('type', 'invisible')
        ->setAllowedValues('type', ['checkbox', 'invisible']);
    }
}
