<?php

namespace App\DataFixtures;

use App\Entity\Social as EntitySocial;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SocialFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $socials = [
            [
                'user'=>'user_tkr',
                'socials'=>[
                    [
                        'nom'=>'Facebook',
                        'icon'=>'fab fa-facebook-f facebook',
                        'path'=>'https://www.facebook.com/malick.tounkara.50/'
                    ],
                    [
                        'nom'=>'Whatsapp',
                        'icon'=>'fab fa-whatsapp whatsapp',
                        'path'=>"https://api.whatsapp.com/send?phone=221781278288&text=Salut, Malick j'ai eu votre contacte sur votre site :"
                    ],
                    [
                        'nom'=>'linkedin',
                        'path'=>"https://www.linkedin.com/in/malick-tounkara-b858a41aa/",
                        'icon'=>"fab fa-linkedin"
                    ]
                ]
            ],
            [
                'user'=>'user_lkp',
                'socials'=>[
                    [
                        'nom'=>'Whatsapp',
                        'icon'=>'fab fa-whatsapp whatsapp',
                        'path'=>"https://api.whatsapp.com/send?phone=221772375369&text=Salut, Pépin j'ai eu votre contacte sur votre site :"
                    ],
                    [
                        'nom'=>'linkedin',
                        'path'=>"https://www.linkedin.com/in/can-va-1a5227223",
                        'icon'=>"fab fa-linkedin"
                    ]
                ]
            ],
            [
                'user'=>'user_nans',
                'socials'=>[
                    [
                        'nom'=>'Whatsapp',
                        'icon'=>'fab fa-whatsapp whatsapp',
                        'path'=>"https://api.whatsapp.com/send?phone=221770431225&text=Salut, Mamadou j'ai eu votre contacte sur votre site :"
                    ]
                ]
            ]
        ];
        foreach ($socials as $key => $value) {
            $user = $this->getReference($value['user']);
            foreach ($value['socials'] as $key => $soc) {    
                $social = new EntitySocial();
                $social->setNom($soc['nom'])
                ->setPath($soc['path'])
                ->setIcon($soc['icon']);
                $user->addSocial($social);
            }
            $manager->persist($user);
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
