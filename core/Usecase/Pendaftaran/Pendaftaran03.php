<?php
namespace Core\Usecase\Pendaftaran;

use Core\Entities\Kendaraan;
use Core\Entities\Pemilik;
use Core\Entities\Penetapan;
use Core\Entities\PajakPkb;

use Core\Repositories\KendaraanRepo;
use Core\Repositories\PemilikRepo;

use Core\Usecase\GenerateItems\Penetapan as UcPenetapan;
use Core\Usecase\Pajak\Pkb as UcPkb;

interface Pendaftaran03Interface {
    public function Process(string $nopol , string $tglPenetapan): Penetapan;
}

class Pendaftaran03 implements Pendaftaran03Interface {

    private $RepoKendaraan;
    private $RepoPemilik;
    
    public function __construct() {
        $this->RepoKendaraan  = new KendaraanRepo();
        $this->RepoPemilik  = new PemilikRepo();
    }

    public function Process(string $nopol , string $tglPenetapan): Penetapan {

        $kendaraan = $this->RepoKendaraan->Fetch($nopol);
        $pemilik = $this->RepoPemilik->Fetch($kendaraan->IDPemilik);

        $idPenetapan = uniqid();
        $penetapan = new Penetapan($idPenetapan, $tglPenetapan);
        $penetapan->JenisPendaftaran = "PU / Pembaharuan";

        // jatuh tempo akhir
        $ucGI = new UcPenetapan();
        list($tglBolehBayar, $tglJatuhTempoAkhir) = $ucGI->SetTglJatuhTempoAkhir($tglPenetapan, $kendaraan->TglJatuhTempo);

        // generate items
        $penetapan->ItemsPenetapan = $ucGI->Generate($idPenetapan, $tglPenetapan, $kendaraan, $pemilik, $tglJatuhTempoAkhir);

        // Tetapkan Pkb Swdkllj Pnbp
        $ucPkb = new UcPkb();
        foreach ($penetapan->ItemsPenetapan as $item) {
            $item->PajakPkb = new PajakPkb();

            // PKB Pokok
            $pokok = $ucPkb->Pokok($item->Kendaraan, $item->TglJTAkhir, $item->TglJTAwal);
            $item->PajakPkb->Pokok = $pokok;

            // PKB Denda
            $denda = $ucPkb->Denda($tglPenetapan, $item->TglJTAkhir, $item->TglJTAwal, $pokok->RupiahTotal);
            $item->PajakPkb->Denda = $denda;

            // SWDKLLJ

            //PNBP
        }

        // Tetepkan jika kereta gandeng
        // total

        return $penetapan;
    }
}