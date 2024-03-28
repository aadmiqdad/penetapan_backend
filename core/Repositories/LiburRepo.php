<?php
namespace Core\Repositories;

interface LiburRepoInterface {
    public function Check(string $tgl): array;
}

class LiburRepo implements LiburRepoInterface {
    
    public function __construct() {
        // 
    }

    public function Check(string $tgl): array {
        return array(false, null);
    }
}