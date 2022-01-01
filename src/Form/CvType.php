<?php

namespace App\Form;

use App\Entity\Cv;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CvType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user',EntityType::class,[
                'class'=>User::class,
                'choice_label'=>function($user ){
                    return $user->getPersonne()->getFullName().' email: '.$user->getEmail();
                }
            ])
            ->add('email')
            ->add('description')
            ->add('poste')
            ->add('adresse')
            ->add('tel')
            ->add('formations',CollectionType::class,[
                'entry_type'=>FormationType::class,
                'label'=>'Formations',
                'entry_options'=>['label'=> false],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cv::class,
        ]);
    }
}
