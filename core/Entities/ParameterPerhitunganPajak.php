<?php
namespace Core\Entities;

class ParameterPerhitunganPajak {
    public $Njkb;
    public $Njub;
    public $Bobot;
    public $Tarif;
    public $TarifOpsen;
    public $Insentif;
    public $TerapkanProgresif;
    public $TerapkanPkbTanpaUb;

    public function __construct() {
        $this->Njkb = 0;
        $this->Njub = 0;
        $this->Bobot = 0.0;
        $this->Tarif = 0.0;
        $this->TarifOpsen = 0.0;
        $this->Insentif = 0.0;
        $this->TerapkanProgresif = false;
        $this->TerapkanPkbTanpaUb = false;
    }
}

