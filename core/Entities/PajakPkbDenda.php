<?php
namespace Core\Entities;

class PajakPkbDenda {
    public $Terlambat;
    public $Bulan;
    public $RupiahTotal;
    public $RupiahTotalBulat;

    public function __construct() {
        $this->Terlambat = [0, 0, 0];
        $this->Bulan = 0;
        $this->RupiahTotal = 0;
    }
}