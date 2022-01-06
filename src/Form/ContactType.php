<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                // 'label'=>'Nom',
                
                'attr'=>[
                    'placeholder'=>'Votre nom (obligatoire)',
                    'class'=>'size-input'
                ],
                'required'=>true,
                'constraints' => [
                new NotBlank(),
                new Length(['min' => 3]),
            ],
            ])
            ->add('email',EmailType::class,[
                'label'=>'Email',
                'attr'=>[
                    'placeholder'=>'Votre email (obligatoire)',
                    'class'=>'size-input'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 3]),
                ],
                'required'=>true,
            ])
            ->add('phone_number',TextType::class,[
                'label'=>'Téléphone',
                'attr'=>[
                    'placeholder'=>'Votre email (obligatoire)',
                    'class'=>'size-input'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 3]),
                ],
                'required'=>true,
            ])
            ->add('message',TextareaType::class,[
                'label'=>'Message',
                'attr'=>[
                    'placeholder'=>'Votre message  (obligatoire)',
                    'cols'=>"10",
                    'rows'=>'5'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 3]),
                ],
                'required'=>true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}