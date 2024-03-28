<?php
namespace Core\Entities;

class Pemilik {
    public $IDPemilik;
    public $NamaPemilik;
    public $Alamat1;
    public $Alamat2;
    public $IDKelurahan;
    public $IDLokasi;

    public function __construct($id) {
        $this->IDPemilik = $id;
        $this->NamaPemilik = "";
        $this->Alamat1 = "";
        $this->Alamat2 = "";
        $this->IDKelurahan = "";
        $this->IDLokasi = "";
    }
}

