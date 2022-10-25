<?php

namespace App\Form;

use App\Entity\ClientRDV;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientRDVType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('societe', TextType::class)
            ->add('ville', TextType::class)
            ->add('pays', TextType::class)
            ->add('personneGestion', PersonneGestionType::class,
            ['label'=>false])
            ->add(
                'rendezVous',
                CollectionType::class,
                [
                    'label' => false,
                    'entry_type' => RendezVousType::class,
                    'entry_options' => ['label' => false],
                    'by_reference' => false,
                    'allow_add' => true,
                    'allow_delete' => true,
                    //'prototype'=>true,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ClientRDV::class,
        ]);
    }
}
