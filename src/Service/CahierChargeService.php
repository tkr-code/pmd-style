<?php 
namespace App\Service;

use App\Repository\CahierChargeRepository;

class CahierChargeService {
    private $cahierChargeRepository;
    public function __construct(CahierChargeRepository $cahierChargeRepository)
    {
        $this->cahierChargeRepository = $cahierChargeRepository;
    }
    public function nextNumber()
    {
        $number= 1;
        $cahierCharges = $this->cahierChargeRepository->findLast();
        foreach($cahierCharges as $value)
        {
           $number +=(int) $value->getNumber();
        }
        return   sprintf("%06s", $number);
    }
}