<?php
namespace Core\Repositories;

use Core\Entities\Kendaraan;
use Core\Entities\ParameterPerhitunganPajak;
use Core\Thirdparty\Pkbsamsatjateng\PkbSamsatJateng;

interface ParameterPerhitunganPajakRepoInterface {
    public function Fetch(Kendaraan $kendaraan, int $thnRakit, int $thnBerlaku, string $noDaftar): ParameterPerhitunganPajak;
}

class ParameterPerhitunganPajakRepo implements ParameterPerhitunganPajakRepoInterface {
    private $Api;

    public function __construct() {
        $this->Api = new PkbSamsatJateng();
    }

    public function Fetch(Kendaraan $kendaraan, int $thnRakit, int $thnBerlaku, string $noDaftar): ParameterPerhitunganPajak {
        $result = new ParameterPerhitunganPajak();
        $err = "";

        $paramApi = array(
            array(
                'id_jenis_kend' => $kendaraan->IDJenisKend,
                'id_jenis_dasar' => $kendaraan->IDJenisMap,
                'id_merk_kend' => $kendaraan->IDMerkKend,
                'id_type_kend' => $kendaraan->IDTypeKend,
                'thn_rakit' => $thnRakit,
                'id_fungsi_kend' => $kendaraan->IDFungsiKend,
                'thn_berlaku' => $thnBerlaku,
                'no_daftar' => $noDaftar,
            ),
        );
        $resultApi = $this->Api->GetParameterPajak($paramApi);
        
        foreach ($resultApi as $v) {

            $b = floatval("1.05");
            $t = floatval("1.05");
            $to = floatval("66");
            $i = floatval($v->insentif);
            $result->Njkb = 350000000;
            $result->Njub = 0;
            $result->Bobot = $b;
            $result->Tarif = $t;
            $result->TarifOpsen = $to;
            $result->Insentif = $i;
            $result->TerapkanProgresif = $v->terapkan_progresif;
            $result->TerapkanPkbTanpaUb = $v->terapkan_pkb_tanpa_ub;

            // $b = floatval($v->bobot);
            // $t = floatval($v->tarif);
            // $to = floatval($v->tarif_opsen);
            // $i = floatval($v->insentif);
            // $result->Njkb = $v->njkb;
            // $result->Njub = $v->njub;
            // $result->Bobot = $b;
            // $result->Tarif = $t;
            // $result->TarifOpsen = $to;
            // $result->Insentif = $i;
            // $result->TerapkanProgresif = $v->terapkan_progresif;
            // $result->TerapkanPkbTanpaUb = $v->terapkan_pkb_tanpa_ub;
        }
        if ($result->Njkb == 0) {
            throw new \Exception("Njkb Kosong!");
        }
        if (intval($result->Bobot) == 0) {
            throw new \Exception("Bobot Kosong!");
        }
        if (intval($result->Tarif) == 0) {
            throw new \Exception("Tarif Kosong!");
        }
        return $result;
    }
}