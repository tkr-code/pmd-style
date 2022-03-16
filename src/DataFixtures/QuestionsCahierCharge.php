<?php

namespace App\DataFixtures;

use App\Entity\QuestionCahierCharge;
use App\Entity\ReponseCahierCharge;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class QuestionsCahierCharge extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $questions =[
            [

                'number'=>1,
                'question'=>'Quel genre d’application voulez-vous ?'
            ],
            [

                'number'=>2,
                'question'=>'Quel est l’objectif de votre site ?'
            ],
            [

                'number'=>3,
                'question'=>'Quels sont vos concurrents ?'
            ],
            [

                'number'=>4,
                'question'=>'Quelles sont vos cibles ?'
            ],
            [

                'number'=>5,
                'question'=>'Quelles sont les questions que vous posent les clients ?'
            ],
            [

                'number'=>6,
                'question'=>'Les fonctionnalités de votre site'
            ],
            [

                'number'=>7,
                'question'=>'Avez-vous des sites références au moins ?'
            ],
            [

                'number'=>8,
                'question'=>'Nom de domaine'
            ],
            [

                'number'=>9,
                'question'=>'Le référencement'
            ],
            [

                'number'=>10,
                'question'=>'Une particularité, une spécialité, un évènement, quelque chose de particulier qui caractérise votre activité ou vos créations'
            ],
            [

                'number'=>11,
                'question'=>'Autres suggestions et questions'
            ],
        ];
        foreach ($questions as $key => $value) {       
        $questionCahierCharge = new QuestionCahierCharge();
        $questionCahierCharge->setNumber($value['number']);
        $questionCahierCharge->setQuestion($value['question']);
        $this->addReference('q'.$value['number'],$questionCahierCharge);
        $manager->persist($questionCahierCharge);
         }
        $manager->flush();
    }
}
