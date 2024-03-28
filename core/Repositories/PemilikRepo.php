<?php
namespace Core\Repositories;

use Core\Entities\Pemilik;


interface PemilikRepoInterface {
    public function Fetch(string $id): Pemilik;
}

class PemilikRepo implements PemilikRepoInterface {
    
    public function __construct() {
        // 
    }

    public function Fetch(string $id): Pemilik {

        $pemilik = new Pemilik($id);
        $pemilik->NamaPemilik = "Aad Miqdad";

        return $pemilik;

    }
}