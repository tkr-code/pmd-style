<?php

namespace App\Form;

use App\Entity\User;
use App\Form\SocialType;
use App\Form\PersonneType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class,[
                'attr'=>[
                    'placeholder'=>'Email'
                ]
            ])
            ->add('roles',ChoiceType::class,[
                'choices'=>[
                    'Administrateur'=>'ROLE_ADMIN',
                    'Utilisateur'=>'ROLE_USER',
                    'Editeur'=>'ROLE_EDITOR',
                    'Client'=>'ROLE_CLIENT',
                    
                ],
                'multiple'=>true,
                'attr'=>[
                    'class'=>'select2'
                ]
            ])
            ->add('personne',PersonneType::class,[
                'label'=>false
                ])
            ->add('isVerified')
            ->add('socials',CollectionType::class,[
                'label'=>false,
                'entry_type'=>SocialType::class,
                'by_reference'=>false,
                'allow_add'=>true,
                'allow_delete'=>true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
             'translation_domain'=>'forms',

        ]);
    }
}