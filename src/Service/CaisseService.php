<?php
namespace App\Service;

use App\Repository\CaisseRepository;

class CaisseService{

    private $caisseRepository;

    public function __construct(CaisseRepository $caisseRepository)
    {
        $this->caisseRepository = $caisseRepository;
    }
 
    /**
     * Determine lem montant total de la caisse
     *
     * @return int
     */
    public function total(){
        $montantTotal = 0;
        $caisses=[];
        foreach ($this->caisseRepository->findGroupByAllCode() as $value) {
            $montantTotal += $value['total'];
        }
        return $montantTotal;
    }

    public function caisses(){
        $pmd = $moh = $tkr= $lkp =0;
        $caisses =[];
        foreach ($this->caisseRepository->findAll() as $key => $value) {
            if($value->getCode() == 'PMD'){
                $pmd += $value->getMontant();
            }elseif ($value->getCode() == 'TKR') {
                $tkr += $value->getMontant();
            }elseif ($value->getCode() == 'MOH') {
                $moh += $value->getMontant();
            }elseif ($value->getCode() == 'LKP') {
                $lkp += $value->getMontant();
            }
        }
    }
}