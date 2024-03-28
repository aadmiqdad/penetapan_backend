<?php
namespace Core\Entities;

class Kendaraan {
    public $IDKendaraan;
    public $IDPemilik;
    public $NoPolisi;
    public $IDLokasi;
    public $IDJenisKend;
    public $IDJenisMap;
    public $IDMerkKend;
    public $IDTypeKend;
    public $ThnBuat;
    public $ThnRakit;
    public $IDGolKend;
    public $JmlSumbu;
    public $IDFungsiKend;
    public $TglJatuhTempo;
    public $TglAkhirStnk;
    public $TglFaktur;
    public $TglKwitansi;
    public $TglFiskal;
    public $TglUbahBentuk;
    public $TglRekom;
    public $Progresif;
    public $KdSts;

    public function __construct($id) {
        $this->IDKendaraan = $id;
        $this->IDPemilik = "";
        $this->NoPolisi = "";
        $this->IDLokasi = "";
        $this->IDJenisKend = "";
        $this->IDJenisMap = "";
        $this->IDMerkKend = "";
        $this->IDTypeKend = "";
        $this->ThnBuat = 0;
        $this->ThnRakit = 0;
        $this->IDGolKend = "";
        $this->JmlSumbu = 0;
        $this->IDFungsiKend = "";
        $this->TglJatuhTempo = date("Y-m-d");
        $this->TglAkhirStnk = date("Y-m-d");
        $this->TglFaktur = "";
        $this->TglKwitansi = "";
        $this->TglFiskal = "";
        $this->TglUbahBentuk = "";
        $this->TglRekom = "";
        $this->Progresif = "";
        $this->KdSts = "";
    }
}

