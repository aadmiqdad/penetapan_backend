<?php
namespace Core\Entities;

class Penetapan {
    public $IDPenetapan;
    public $TglPenetapan;
    public $JenisPendaftaran;
    public $TotalPembayaran;
    public $ItemsPenetapan;

    public function __construct($id, $tglPenetapan) {
        $this->IDPenetapan = $id;
        $this->TglPenetapan = $tglPenetapan;
        $this->ItemsPenetapan = [];
    }
}