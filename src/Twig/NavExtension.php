<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Symfony\Contracts\Translation\TranslatorInterface;

class NavExtension extends AbstractExtension
{
    private $translator;
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }
    public function getFunctions(): array
    {
        return [
            new TwigFunction('sidebar', [$this, 'getNavs'])
        ];
    }

    public function getNavs()
    {
        return
            [
                'navs' =>
                [
                    [
                        'name' => $this->translator->trans('Dashboard'),
                        'icon' => 'fas fa-tachometer-alt',
                        'links' => [
                            [
                                'name' => $this->translator->trans('Dashboard') . ' 1',
                                'path' => 'admin'
                            ]
                        ]
                    ],
                    [
                        'name' => 'Pmd Developper',
                        'icon' => 'fa fa-home',
                        'links' =>
                        [
                            [
                                'name' => $this->translator->trans('Home'),
                                'path' => 'home'
                            ],
                            [
                                'name' => 'A propos',
                                'path' => 'about'
                            ],
                            [
                                'name' => 'Contact',
                                'path' => 'contact'
                            ],
                        ]
                    ],
                    [
                        'name' => 'Profile',
                        'icon' => 'fas fa-user',
                        'path' => 'profile_index',
                    ],
                    [
                        'name' => 'Cahier de charge',
                        'path' => 'admin_cahier_charge_index',
                        'icon' => 'fas fa-book-open'
                    ],
                    [
                        'name' => 'Caisse',
                        'path' => 'admin_caisse_index',
                        'icon' => 'fas fa-funnel-dollar'
                    ],

                ],
                'admin' =>
                [
                    [
                        'name' => $this->translator->trans('User'),
                        'icon' => 'fas fa-users',
                        'links' => [
                            [
                                'name' => $this->translator->trans('Users'),
                                'path' => 'user_index',
                            ],
                            [
                                'name' => $this->translator->trans('User'),
                                'path' => 'user_new',
                            ],
                        ]
                    ],
                    [
                        'name' => 'Gestion Projets',
                        'icon' => 'fa fa-home',
                        'links' =>
                        [
                            [
                                'name' => 'Créer Projet',
                                'path' => 'projet_new'
                            ],
                            [
                                'name' => 'Tous Les Projets',
                                'path' => 'projet_index'
                            ],

                        ]
                    ],
                    [
                        'name' => 'Gestion Formations',
                        'icon' => 'fa fa-home',
                        'links' =>
                        [
                            [
                                'name' => 'Créer Module',
                                'path' => 'module_new'
                            ],
                            [
                                'name' => 'Tous Les Modules',
                                'path' => 'module_index'
                            ],
                            [
                                'name' => 'Créer Centre formation',
                                'path' => 'centre_formation_new'
                            ],
                            [
                                'name' => 'Centres Formations',
                                'path' => 'centre_formation_index'
                            ],

                        ]
                    ],
                    [
                        'name' => 'Gestion Rendez-vous',
                        'icon' => 'fa fa-home',
                        'links' =>
                        [
                            [
                                'name' => 'Créer Rendez-vous',
                                'path' => 'gestion_rendez_vous_client_new'
                            ],
                            [
                                'name' => 'Tous Les Rendez-vous',
                                'path' => 'gestion_rendez_vous_client_index'
                            ],
                            
                        ]
                    ],
                    [
                        'name' => 'Gestion Depenses',
                        'icon' => 'fa fa-home',
                        'links' =>
                        [
                            [
                                'name' => 'Créer Depense',
                                'path' => 'gestion_depense_new'
                            ],
                            [
                                'name' => 'Toutes Les Depenses',
                                'path' => 'gestion_depense_index'
                            ],
                            
                        ]
                    ],
                    [
                        'name' => 'Gestion Investissement',
                        'icon' => 'fa fa-home',
                        'links' =>
                        [
                            [
                                'name' => 'Créer Investissement',
                                'path' => 'admin_gestion_contractant_investissement_new'
                            ],
                            [
                                'name' => 'Tous Les Investissements',
                                'path' => 'admin_gestion_contractant_investissement_index'
                            ],
                            
                        ]
                    ],


                ]
            ];
    }
}
