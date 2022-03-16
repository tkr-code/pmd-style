<?php

namespace App\DataFixtures;

use App\Entity\ReponseCahierCharge as EntityReponseCahierCharge;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ReponseCahierCharge extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $lorem = 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Laboriosam, id?';
        $reponseCahierCharge = new EntityReponseCahierCharge();
        $reponseCahierCharge->setReponse($lorem);
        $reponseCahierCharge->setCahierCharge($this->getReference('cahier_1'));
        $reponseCahierCharge->setQuestion($this->getReference('q1'));
        
        $manager->persist($reponseCahierCharge);

        $manager->flush();
    }
    public function getDependencies()
    {
        return[
            QuestionsCahierCharge::class,
            CahierChargeFixtures::class
        ];
    }
}
