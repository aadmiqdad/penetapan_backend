<?php
namespace Core\Repositories;

interface TarifProgresifRepoInterface {
    public function Fetch(string $progresif): float;
}

class TarifProgresifRepo implements TarifProgresifRepoInterface {
    public function Fetch(string $progresif): float {
        $progresif = str_replace(" ", "", $progresif);
        $p = intval($progresif);
        if ($p === false) {
            return 0.00;
        }
        switch ($p) {
            case 1:
                return 0.00;
            case 2:
                return 0.50;
            case 3:
                return 1.00;
            case 4:
                return 1.50;
            case 5:
                return 2.00;
            default:
                return 0.00;
        }
    }
}