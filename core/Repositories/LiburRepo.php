<?php
namespace Core\Repositories;

interface LiburRepoInterface {
    public function Check(string $tgl): bool;
}

class LiburRepo implements LiburRepoInterface {
    
    public function __construct() {
        // 
    }

    public function Check(string $tgl): bool {
        return false;
    }
}