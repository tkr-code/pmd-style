<?php

namespace App\DataFixtures;

use App\Entity\Formations;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\FormationOption;
class FormationsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $formationsArray = [
            [
                'ref' => 'formation_1',
                'nom' => 'Algorithme',
                'detail' => 'Un algorithme est une procédure de calcul bien définie qui prend en entrée un ensemble de valeurs et qui délivre en sortie un ensemble de valeurs.',
                'desc' => 'Un algorithme est une procédure de calcul bien définie qui prend en entrée un ensemble de valeurs et qui délivre en sortie un ensemble de valeurs.',
                'options' => [
                    [
                        'title' => 'Initiation a l\'algorithmique',
                        'contenu' => 'Un algorithme est une procédure de calcul bien définie qui prend en entrée un ensemble de valeurs et qui délivre en sortie un ensemble de valeurs.',
                    ],
                    [
                        'title' => 'Travaux dirigés',
                        'contenu' => 'Un algorithme est une procédure de calcul bien définie qui prend en entrée un ensemble de valeurs et qui délivre en sortie un ensemble de valeurs.',
                    ],
                    [
                        'title' => 'Exercice et correcton',
                        'contenu' => 'Un algorithme est une procédure de calcul bien définie qui prend en entrée un ensemble de valeurs et qui délivre en sortie un ensemble de valeurs.',
                    ],
                ]
            ],
            [
                'ref' => 'formation_2',
                'nom' => 'Php',
                'detail' => 'Un algorithme est une procédure de calcul bien définie qui prend en entrée un ensemble de valeurs et qui délivre en sortie un ensemble de valeurs.',
                'desc' => 'Un algorithme est une procédure de calcul bien définie qui prend en entrée un ensemble de valeurs et qui délivre en sortie un ensemble de valeurs.',
                'options' => []
            ],
            [
                'ref' => 'formation_3',
                'nom' => 'Java',
                'detail' => 'Un algorithme est une procédure de calcul bien définie qui prend en entrée un ensemble de valeurs et qui délivre en sortie un ensemble de valeurs.',
                'desc' => 'PHP (officiellement, ce sigle est un acronyme récursif pour PHP Hypertext Preprocessor) est un langage de scripts généraliste et Open Source, spécialement conçu pour le développement d\'applications web. Il peut être intégré facilement au HTML. ',
                'options' => []
            ],
        ];
        foreach ($formationsArray as $key => $value) {
            # code...
            $formations = new Formations();
            $formations
                ->setNom($value['nom'])
                ->setDetail($value['detail'])
                ->setDescription($value['desc'])
                ->setIsActive(true);
            foreach ($value['options'] as $key => $value2) {
                $formationOption  = new FormationOption();
                $formationOption
                ->setTitre($value2['title'])
                ->setContenu($value2['contenu'])
                ->setIsActive(true)
                ;
                $formations->addOption($formationOption);
            }
            $manager->persist($formations);
        }

        $manager->flush();
    }
}
