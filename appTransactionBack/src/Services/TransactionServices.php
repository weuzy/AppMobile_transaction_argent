<?php


namespace App\Services;


class TransactionServices
{
    private $TTC = [
        "0-5000" => 425, "5000-10000" => 850,
        "10000-15000" => 1270, "15000-20000" => 1695,
        "20000-50000" => 2500, "50000-60000" =>3000,
        "60000-75000" => 4000, "75000-120000" => 5000,
        "120000-150000" => 6000, "150000-200000" => 7000,
        "200000-250000" => 8000, "250000-300000" => 9000,
        "300000-400000" => 12000, "400000-750000" => 15000,
        "750000-900000" => 22000, "900000-1000000" => 25000,
        "1000000-1125000" => 27000, "1125000-2000000" => 30000
    ];
    public function calculatriceFrais($montant) {
        foreach ($this -> TTC as $key => $value) {
            [$min, $max] = explode('-', $key);
            if ($montant >= $min && $montant < $max) {
                return $value;
            }
        }
        if ($montant >= 2000000) {
            return ($montant * 2) / 100;
        }
    }
    public function commisions($TTC) {
        $parts = [];
        /*
            ​ 40 % pour l’état
            ​ 30% pour le transfert d’argent
            ​ 30% restant réparti comme suit :
             ​ 10% pour l’opérateur qui a effectué le dépôt.
             ​ 20% pour l’opérateur qui a effectué le retrait
        */
        $parts['fraisEtat'] = ($TTC * 40) / 100;
        $parts['fraisSystem'] = ($TTC * 30) / 100;
        $parts['fraisDepot'] = ($TTC * 10) / 100;
        $parts['fraisRetrait'] = ($TTC * 20) / 100;
        return $parts;
    }
}
