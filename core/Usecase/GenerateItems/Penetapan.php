<?php
namespace Core\Usecase\GenerateItems;

use Core\Entities\Kendaraan;
use Core\Entities\Pemilik;
use Core\Entities\PenetapanItem;

interface PenetapanInterface {
    public function SetTglJatuhTempoAkhir(string $tglPenetapan, string $tglJatuhTempo): array;
    public function Generate(string $idPenetapan, string $tglPenetapan, Kendaraan $kendaraan, Pemilik $pemilik, string $tglJatuhTempoAkhir): array;
}

class Penetapan implements PenetapanInterface {
    private $nBulanBolehBayar;

    public function __construct() {
        $this->nBulanBolehBayar = 2;
    }

    public function SetTglJatuhTempoAkhir(string $tglPenetapan, string $tglJatuhTempo): array {
        $tglBolehBayar = date('Y-m-d', strtotime('-' . $this->nBulanBolehBayar . ' months', strtotime($tglJatuhTempo)));

        if (strtotime($tglPenetapan) < strtotime($tglBolehBayar)) {
            $tglJatuhTempoAkhir = $tglJatuhTempo;
            throw new \Exception("Belum waktunya bayar! Boleh bayar tanggal ".$tglBolehBayar);
        }

        $tglJatuhTempoAkhir = $tglJatuhTempo;
        while (strtotime($tglJatuhTempoAkhir) < strtotime($tglPenetapan)) {
            $tglJatuhTempoAkhir = date('Y-m-d', strtotime('+1 year', strtotime($tglJatuhTempoAkhir)));
        }

        $tambahSatuTahunJalan = date('Y-m-d', strtotime('-' . $this->nBulanBolehBayar . ' months', strtotime($tglJatuhTempoAkhir)));
        if (strtotime($tambahSatuTahunJalan) < strtotime($tglPenetapan)) {
            $tglJatuhTempoAkhir = date('Y-m-d', strtotime('+1 year', strtotime($tglJatuhTempoAkhir)));
        }

        return array($tglBolehBayar, $tglJatuhTempoAkhir);
    }

    public function updateTglAkhirStnk(string $tglAkhirStnk, string $tglJTAwal): string {
        while (strtotime($tglAkhirStnk) <= strtotime($tglJTAwal)) {
            $tglAkhirStnk = date('Y-m-d', strtotime('+5 years', strtotime($tglAkhirStnk)));
        }
        return $tglAkhirStnk;
    }

    public function Generate(string $idPenetapan, string $tglPenetapan, Kendaraan $kendaraan, Pemilik $pemilik, string $tglJatuhTempoAkhir): array {
        $result = array();
        $i = 0;
        $tmp = $tglJatuhTempoAkhir;
        while ( strtotime('-1 year', strtotime($tmp)) >= strtotime($kendaraan->TglJatuhTempo) ) {
            if ($i > 5) {
                break;
            }

            $t = new PenetapanItem();
            $t->R = strval($i);
            $t->IDPenetapanItem = $idPenetapan . "-" . $t->R;
            $t->TglJTAkhir = $tmp;
            $tmp = date('Y-m-d', strtotime('-1 year', strtotime($tmp)));
            $t->TglJTAwal = $tmp;
            $k = clone $kendaraan;
            $k->TglJatuhTempo = $t->TglJTAkhir;
            $t->Kendaraan = $k;
            $t->Pemilik = $pemilik;
            $result[] = $t;
            $i++;
        }

        if (strtotime($result[0]->Kendaraan->TglAkhirStnk) < strtotime('+1 day', strtotime($tglPenetapan))) {
            $tglAkhirStnk = $this->updateTglAkhirStnk($result[0]->Kendaraan->TglAkhirStnk, $result[0]->TglJTAwal);
            $result[0]->Kendaraan->TglAkhirStnk = $tglAkhirStnk;
        }

        return $result;
    }
}