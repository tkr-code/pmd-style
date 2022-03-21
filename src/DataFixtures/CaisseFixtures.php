<?php

namespace App\DataFixtures;

use App\Entity\Caisse;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CaisseFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $caisses = 
        [
            [
                'code'=>'PMD',
                'libelle'=>'Hebergement de janvier',
                'montant'=>-2000,
                'type'=>'Débit'
            ],
            [
                'code'=>'PMD',
                'libelle'=>'Hebergement de janvier',
                'montant'=>-2000,
                'type'=>'Débit'
            ],
            [
                'code'=>'PMD',
                'libelle'=>'Hebergement de fevrier',
                'montant'=>-2000,
                'type'=>'Débit'
            ],
            [
                'code'=>'PMD',
                'libelle'=>'Hebergement de Mars',
                'montant'=>-2000,
                'type'=>'Débit'
            ],
            [
                'code'=>'TKR',
                'libelle'=>'Versemenent de janvier',
                'montant'=>2000,
                'type'=>'Crédit'
            ],
            [
                'code'=>'TKR',
                'libelle'=>'Versemenent de janvier',
                'montant'=>2000,
                'type'=>'Crédit'
            ],
            [
                'code'=>'TKR',
                'libelle'=>'Versemenent de janvier',
                'montant'=>2000,
                'type'=>'Crédit'
            ],
            [
                'code'=>'TKR',
                'libelle'=>'Versemenent de janvier',
                'montant'=>2000,
                'type'=>'Crédit'
            ],
            [
                'code'=>'TKR',
                'libelle'=>'Versemenent de janvier',
                'montant'=>2000,
                'type'=>'Crédit'
            ],
            [
                'code'=>'TKR',
                'libelle'=>'Versemenent de janvier',
                'montant'=>2000,
                'type'=>'Crédit'
            ],
            [
                'code'=>'TKR',
                'libelle'=>'Versemenent de janvier',
                'montant'=>2000,
                'type'=>'Crédit'
            ],
            [
                'code'=>'MOH',
                'libelle'=>'Versemenent de janvier',
                'montant'=>8000,
                'type'=>'Crédit'
            ],
            [
                'code'=>'LKP',
                'libelle'=>'Versemenent de janvier',
                'montant'=>2000,
                'type'=>'Crédit'
            ]
        ];
        foreach ($caisses as $key => $value) {
            $caisse = new Caisse();
            $caisse->setCode($value['code'])
            ->setLibelle($value['libelle'])
            ->setType($value['type'])
            ->setMontant($value['montant']);
            $manager->persist($caisse);
        }
        $manager->flush();
    }
}
