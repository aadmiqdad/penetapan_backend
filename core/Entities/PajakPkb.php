<?php
namespace Core\Entities;

use Core\Entities\PajakPkbPokok;
use Core\Entities\PajakPkbDenda;

class PajakPkb {
    public $Pokok;
    public $Denda;

    public function __construct() {
        $this->Pokok = new PajakPkbPokok();
        $this->Denda = new PajakPkbDenda();
    }
}