<?php

namespace App\DataFixtures;

use App\Entity\Competence;
use App\Entity\Cv;
use App\Entity\Formation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CvFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $cv = new Cv();
        $cv->setUser($this->getReference('user_tkr'));
        $cv->setAdresse('sacre cour 2')
        ->setDescription('Je suis un informaticien avec une connaissance holistique du développement et de la conception de logiciels.')
        ->setEmail('malick.tounkara.1@gmail.com')
        ->setPoste('Dévéloppeur Web')
        ->setTel('+221 78 127 82 88');
        $fomation = new Formation();
        $fomation->setAnnee('Oct 2019 - Août 2020')
        ->setDiplome('LICENCE EN INFORMATIQUE')
        ->setEcole('IPG/ISTI')
        ->setPays('Sénégal')
        ->setTitle('Developpeur')
        ->setDescription('Je prend un projet, qui a été pensée et réfléchie par un client ou une équipe de conception, et le transforme en application.')
        ->setVille('Dakar');
        $cv->addFormation($fomation);

        $competence = new Competence();
        $competence->setNom('Symfony')
        ->setValeur(80);
        $cv->addCompetence($competence);

        $manager->persist($cv);

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }
}
