<?php

namespace App\DataFixtures;

use App\Entity\CahierCharge;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CahierChargeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $cahierCharge = new CahierCharge();
        $cahierCharge->setFullName('Malick Tounkara');
        $cahierCharge->setEmail('malick.tounkara.1@gmail.com');
        $cahierCharge->setTel('71278288');
        $cahierCharge->setStatus('En attente');
        $cahierCharge->setNumber('num001');
        $this->addReference('cahier_1',$cahierCharge);
        $manager->persist($cahierCharge);
        $manager->flush();
    }
}
