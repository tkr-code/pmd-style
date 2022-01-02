<?php

namespace App\DataFixtures;

use App\Entity\Competence;
use App\Entity\Cv;
use App\Entity\Experience;
use App\Entity\Formation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CvFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $cvs = [
            [
                'user'=>'user_tkr',
                'slug'=>'malick-tounkara',
                'adresse'=>'Sacre coeur 2',
                'description'=>'Je suis un informaticien avec une connaissance holistique du développement et de la conception de logiciels.',
                'email'=>'malick.tounkara.1@gmail.com',
                'poste'=>'Dévéloppeur Web',
                'tel'=>'+221 78 127 82 88',
                'formations'=>[
                    [
                        'annee'=>'Oct 2019 - Août 2020',
                        'diplome'=>'LICENCE EN INFORMATIQUE',
                        'ecole'=>'IPG/ISTI',
                        'pays'=>'Sénégal',
                        'title'=>'Dévéloppeur Web',
                        'description'=>'Je prend un projet, qui a été pensée et réfléchie par un client ou une équipe de conception, et le transforme en application.',
                        'ville'=>'Dakar'
                    ],
                    [
                        'annee'=>'Oct 2018 - Août 2019',
                        'diplome'=>'DTS EN INFORMATIQUE',
                        'ecole'=>'IPG/ISTI',
                        'pays'=>'Sénégal',
                        'title'=>'Analyste programmeur',
                        'description'=>"Je m'occupe de créer des logiciels. Je suis également chargé de m'occuper de la maintenance des anciens logiciels et du suivi des nouveaux. J'analyse d'une part un souhait émis par le client et d'autre part programmer cette demande",
                        'ville'=>'Dakar'
                    ],
                    [
                        'annee'=>'Oct 2016 - Juil 2017',
                        'diplome'=>'BACCALAUREAT D',
                        'ecole'=>'LYCEE NATIONAL LEOM MBA',
                        'pays'=>'Gabon',
                        'title'=>null,
                        'description'=>null,
                        'ville'=>'Libreville'
                    ]
                ],
                'competences'=>[
                    'Symfony'=>85,
                    'Uml'=>80,
                    'Javascript'=>80,
                    'Java'=>50,
                    'html & Css'=>70,
                    'maintenance Informatique'=>50
                ]
            ],
            [
                'user'=>'user_nans',
                'slug'=>'mamadou-nanna-dieme',
                'adresse'=>'Point E',
                'description'=>null,
                'email'=>'diememamadou96@gmail.com',
                'poste'=>'Dévéloppeur Web',
                'tel'=>'+221 77 043 12 25',
                'formations'=>[
                    [
                        'annee'=>'Oct 2019 - Août 2020',
                        'diplome'=>'LICENCE EN INFORMATIQUE',
                        'ecole'=>'IPG/ISTI',
                        'pays'=>'Sénégal',
                        'title'=>null,
                        'description'=>null,
                        'ville'=>'Dakar'
                    ],
                    [
                        'annee'=>'Oct 2018 - Août 2019',
                        'diplome'=>'BREVET DE TECHNICIEN SUPERIEUR EN INFO-GESTION (BTS)',
                        'ecole'=>'IPG/ISTI',
                        'pays'=>'Sénégal',
                        'title'=>null,
                        'description'=>null,
                        'ville'=>'Dakar'
                    ],
                    [
                        'annee'=>'Oct 2018 - Août 2019',
                        'diplome'=>'DTS EN INFORMATIQUE',
                        'ecole'=>'IPG/ISTI',
                        'pays'=>'Sénégal',
                        'title'=>'Analyste programmeur',
                        'description'=>null,
                        'ville'=>'Dakar'
                    ],
                    [
                        'annee'=>'Oct 2015 - Juil 2017',
                        'diplome'=>'MATH PHYSIQUE INFORMATIQUE (UCAD)',
                        'ecole'=>'LYCEE NATIONAL LEOM MBA',
                        'pays'=>'Gabon',
                        'title'=>null,
                        'description'=>null,
                        'ville'=>'Libreville'
                    ],
                    [
                        'annee'=>'Oct 2014 - Juil 2015',
                        'diplome'=>'BACCALAUREAT S2',
                        'ecole'=>'NOn fournie',
                        'pays'=>'Sénégal',
                        'title'=>null,
                        'description'=>null,
                        'ville'=>'non-fournie'
                    ]
                ],
                'competences'=>[
                    'Analyse informatique'=>85,
                    'Symfony'=>85,
                    'Angular'=>80,
                    'Wordpresse'=>80,
                    'Mysql'=>80,
                    'Sql Server'=>85,
                    'Oracle'=>80,
                    'Javascript'=>80,
                    'Java'=>86,
                    'html & Css'=>50,
                ]
            ]
        ];
        foreach ($cvs as $cv) {
            # code...
        $Cv = new Cv();
        $Cv->setUser($this->getReference($cv['user']));
        $Cv->setSlug($cv['slug']);
        $Cv->setAdresse($cv['adresse'])
        ->setDescription($cv['description'])
        ->setEmail($cv['email'])
        ->setPoste($cv['poste'])
        ->setTel($cv['tel']);
        foreach ($cv['formations'] as $formation) {   
            $fomation1 = new Formation();
            $fomation1->setAnnee($formation['annee'])
            ->setDiplome($formation['diplome'])
            ->setEcole($formation['ecole'])
            ->setPays($formation['pays'])
            ->setTitle($formation['title'])
            ->setDescription($formation['description'])
            ->setVille($formation['ville']);
            $Cv->addFormation($fomation1);
        }
        foreach ($cv['competences'] as $nom => $valeur) {
            $competence = new Competence();
            $competence->setNom($nom)
            ->setValeur($valeur);
            $Cv->addCompetence($competence);
        }

        $manager->persist($Cv);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }
}
