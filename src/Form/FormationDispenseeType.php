<?php

namespace App\Form;

use App\Entity\FormationDispensee;
use App\Entity\Module;
use App\Repository\ModuleRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class FormationDispenseeType extends AbstractType
{   
    #afin d'avoir l'utilisateur courant dans le formType
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }   
    

    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        #je recupere le current User
        $user = $this->security->getUser();
        #c'est pour ne recupere que les modules cree par l'utilisateur

        $builder
            ->add('volumeHoraire')
            ->add('valeurHeure')
            /*  ->add(
                'etat',
                ChoiceType::class,
                [
                    'choices' =>
                    [
                        'En Cour' => 'En Cour',
                        'Annuler' => 'Annulé',
                        'Suspendu' => 'Suspendu',
                        'Achevée' => 'Achevée',
                    ],
                    'placeholder'=>'Quel est l\'etat du cour ? '
                ]
            ) */
            ->add('dateDebut', DateType::class, ['widget' => 'single_text'])
            // ->add('dateFin', DateType::class, ['widget' => 'single_text'])
            ->add(
                'module',
                EntityType::class,
                [
                    'class' => Module::class,
                    'choice_label' => 'abreviation',
                    'placeholder' => 'veuillez choisir un Module',
                    'query_builder' => function (ModuleRepository $mr) {
                        return $mr->createQueryBuilder('m')
                            ->andWhere('m.user = :id')
                            ->setParameter('id', $this->security->getUser())
                            ;
                    },
                ]
            )
            ->add(
                'classe',
                ClasseFormationType::class,
                ['mapped' => false]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FormationDispensee::class,
        ]);
    }
}
