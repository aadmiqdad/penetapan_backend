<?php
namespace Core\Repositories;

use Core\Entities\Kendaraan;

interface KendaraanRepoInterface {
    public function Fetch(string $nopol): Kendaraan;
}

class KendaraanRepo implements KendaraanRepoInterface {
    
    public function __construct() {
        // 
    }

    public function Fetch(string $nopol): Kendaraan {

        $kendaraan = new Kendaraan(uniqid());
        $kendaraan->TglJatuhTempo = "2023-07-27";
        $kendaraan->TglAkhirStnk = "2023-07-27";
        $kendaraan->IDPemilik = uniqid();
        $kendaraan->NoPolisi = $nopol;
        $kendaraan->IDJenisKend = "801";
        $kendaraan->IDJenisMap = "801";
        $kendaraan->IDMerkKend = "6801";
        $kendaraan->IDTypeKend = "1002";
        $kendaraan->ThnBuat = 2023;
        $kendaraan->ThnRakit = 2023;
        $kendaraan->IDFungsiKend = "01";
        $kendaraan->Progresif = 1;
        $kendaraan->JmlSumbu = 2;

        return $kendaraan;

    }
}