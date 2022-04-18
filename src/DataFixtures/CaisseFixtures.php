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
                'libelle'=>'Hebergement de décembre',
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
                'libelle'=>'Hebergement de fevrier, mars et avril',
                'montant'=>-5500,
                'type'=>'Débit'
            ],
            [
                'code'=>'TKR',
                'libelle'=>'Cotisation de décembre',
                'montant'=>2000,
                'type'=>'Crédit'
            ],
            [
                'code'=>'TKR',
                'libelle'=>'Cotisation de janvier',
                'montant'=>2000,
                'type'=>'Crédit'
            ],
            [
                'code'=>'TKR',
                'libelle'=>'Cotisation de février',
                'montant'=>2000,
                'type'=>'Crédit'
            ],
            [
                'code'=>'TKR',
                'libelle'=>'Cotisation de mars',
                'montant'=>2000,
                'type'=>'Crédit'
            ],
            [
                'code'=>'LKP',
                'libelle'=>'Cotisation de décembre',
                'montant'=>2000,
                'type'=>'Crédit'
            ],
            [
                'code'=>'LKP',
                'libelle'=>'Cotisation de janvier',
                'montant'=>2000,
                'type'=>'Crédit'
            ],
            [
                'code'=>'LKP',
                'libelle'=>'Cotisation de février',
                'montant'=>2000,
                'type'=>'Crédit'
            ],
            [
                'code'=>'LKP',
                'libelle'=>'Cotisation de mars',
                'montant'=>2000,
                'type'=>'Crédit'
            ],
            [
                'code'=>'MOH',
                'libelle'=>'Cotisation de décembre',
                'montant'=>2000,
                'type'=>'Crédit'
            ],
            [
                'code'=>'MOH',
                'libelle'=>'Cotisation de janvier',
                'montant'=>2000,
                'type'=>'Crédit'
            ],
            [
                'code'=>'MOH',
                'libelle'=>'Cotisation de février',
                'montant'=>2000,
                'type'=>'Crédit'
            ],
            [
                'code'=>'MOH',
                'libelle'=>'Cotisation de mars',
                'montant'=>2000,
                'type'=>'Crédit'
            ],
        ];
        foreach ($caisses as $key => $value) {
            $caisse = new Caisse();
            $caisse->setCode($value['code'])
            ->setLibelle($value['libelle'])
            ->setType($value['type'])
            ->setIsEditable(false)
            ->setMontant($value['montant']);
            $manager->persist($caisse);
        }
        $manager->flush();
    }
}
