<?php

namespace App\DataFixtures;

use App\Entity\FormationOption;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FormationOptionFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $formationOption = new FormationOption();
        // $manager->persist($formationOption);

        // $manager->flush();
    }
}
