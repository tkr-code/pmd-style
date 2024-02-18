<?php

namespace App\DataFixtures;

use App\Entity\Application;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ApplicationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $application = new Application();
        $application->setNom('Gestion depenses');
        $manager->persist($application);
        $manager->flush();
    }
}
