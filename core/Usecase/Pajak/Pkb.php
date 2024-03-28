<?php
namespace Core\Usecase\Pajak;

use Core\Entities\Kendaraan;
use Core\Entities\PajakPkbPokok;
use Core\Entities\PajakPkbDenda;

use Core\Repositories\TarifProgresifRepo;
use Core\Repositories\ParameterPerhitunganPajakRepo;
use Core\Repositories\LiburRepo;

interface PkbInterface {
    public function Pokok(Kendaraan $kendaraan, string $tglJTAkhir, string $tglJTAwal): PajakPkbPokok;
    public function Denda(string $tglPenetapan, string $tglJTAkhir, string $tglJTAwal, int $rupiahPokok): PajakPkbDenda;
}

class Pkb implements PkbInterface {
    private $rTp;
    private $rPpp;
    private $rL;
    public $PersenDenda;
    public $rupiahMaxPkbKeteraGandeng;

    public function __construct() {
        $this->rTp = new TarifProgresifRepo();
        $this->rPpp = new ParameterPerhitunganPajakRepo();
        $this->rL = new LiburRepo();
        $this->PersenDenda = 2;
        $this->rupiahMaxPkbKeteraGandeng = 1000000;
    }

    public function Pokok(Kendaraan $kendaraan, string $tglJTAkhir, string $tglJTAwal): PajakPkbPokok {

        $parameter = $this->rPpp->Fetch($kendaraan, $kendaraan->ThnRakit, date('Y', strtotime($tglJTAwal)), $kendaraan->NoPolisi);
        
        [$y, $m, $d, , , ] = Diff($tglJTAwal, $tglJTAkhir);
        
        $bulanPajak = JumlahBulan($y, $m, $d);
        
        $pkbPusat = ($parameter->Njkb + $parameter->Njub) * ($parameter->Tarif / 100) * $parameter->Bobot * ($parameter->Insentif / 100);
        $pkbDaerah = $pkbPusat * ($parameter->TarifOpsen / 100);
        
        if ($pkbPusat < 0) {
            $pkbPusat = 0;
        }
        if ($pkbDaerah < 0) {
            $pkbDaerah = 0;
        }

        $pkbPusat = Pembulatan500(intval($pkbPusat));
        $pkbDaerah = Pembulatan500(intval($pkbDaerah));

        $totPokokPkb = 0;
        
        $totPokokPkb = $pkbPusat + $pkbDaerah;

        $totPokokPkbBulat = Pembulatan500(intval($totPokokPkb));
        
        $PajakPkbPokok = new PajakPkbPokok();
        $PajakPkbPokok->ParameterPerhitunganPajak = $parameter;
        $PajakPkbPokok->Bulan = $bulanPajak;
        
        $PajakPkbPokok->RupiahPusat = $pkbPusat;
        $PajakPkbPokok->RupiahDaerah = $pkbDaerah;
        
        $PajakPkbPokok->RupiahTotal = $totPokokPkbBulat;
        
        return $PajakPkbPokok;
    }

    public function Denda(string $tglPenetapan, string $tglJTAkhir, string $tglJTAwal, int $rupiahPokok): PajakPkbDenda {
        if ($tglJTAwal > date('Y-m-d', strtotime($tglPenetapan . ' -1 day'))) {
            return new PajakPkbDenda();
        }
        $tglAwal = $tglJTAwal;
        if ($tglPenetapan < $tglJTAkhir) {
            while (true) {
                $hariLibur = $this->rL->Check($tglAwal);
                if ($hariLibur === true) {
                    $tglAwal = date('Y-m-d', strtotime($tglAwal . ' +1 day'));
                } else {
                    break;
                }
            }
        }
        list($y, $m, $d, $h, $i, $s) = Diff($tglAwal, $tglPenetapan);
        $bulanDenda = JumlahBulan($y, $m, $d);
        if ($bulanDenda > 24) {
            $bulanDenda = 24;
        }
        $totDenda = floatval($rupiahPokok) * (floatval($bulanDenda) * ($this->PersenDenda / 100));
        $totDendaBulat = Pembulatan500(intval($totDenda));

        $PajakPkbDenda = new PajakPkbDenda();
        $PajakPkbDenda->Terlambat = [$y, $m, $d];
        $PajakPkbDenda->Bulan = $bulanDenda;
        $PajakPkbDenda->RupiahTotal = $totDendaBulat;
        return $PajakPkbDenda;
    }


}

function Diff($a, $b) {
    $date1=date_create($a);
    $date2=date_create($b);
    $diff=date_diff($date1,$date2);

    return array($diff->y, $diff->m, $diff->d, $diff->h, $diff->i, $diff->s);
}

function JumlahBulan($year, $month, $day) {
    $result = 0;
    if ($year > 0) {
        $result = $result + ($year * 12);
    }
    if ($month > 0) {
        $result = $result + $month;
    }
    if ($day > 0) {
        $result = $result + 1;
    }
    return $result;
}

function Pembulatan500($nilai) {
    if ($nilai == 0) {
        return $nilai;
    }

    $ratusan = substr($nilai, -3);
    if ($ratusan<=500) {
        $akhir = $nilai + (500-$ratusan);
    }
    else {
        $akhir = $nilai + (1000-$ratusan);
    }
    return $akhir;
}
