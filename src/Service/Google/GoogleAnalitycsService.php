<?php
namespace App\Service\Google;

use Twig\Environment;

class GoogleAnalitycsService {
    private $twig; 
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    //FONCTION D'INITIALISATION ET D'AUTHENTIFICATION
    public function initialize(){
        
    }

}