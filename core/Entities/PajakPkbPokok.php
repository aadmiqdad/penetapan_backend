<?php
namespace Core\Entities;

use Core\Entities\ParameterPerhitunganPajak;

class PajakPkbPokok {
    public $ParameterPerhitunganPajak;
    public $Bulan;
    public $RupiahPusat;
    public $RupiahDaerah;
    public $RupiahTotal;

    public function __construct() {
        $this->ParameterPerhitunganPajak = new ParameterPerhitunganPajak();
        $this->Bulan = 0;
        $this->RupiahPusat = 0;
        $this->RupiahDaerah = 0;
        $this->RupiahTotal = 0;
    }
}