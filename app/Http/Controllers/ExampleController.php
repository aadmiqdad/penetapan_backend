<?php

namespace App\Http\Controllers;

use Core\Usecase\Pendaftaran\Pendaftaran03;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function penetapan()
    {
        try {
            $nopol = "H1";
            $tglPenetapan = "2024-04-27";

            $penetapan = new Pendaftaran03();
            $result = $penetapan->Process($nopol, $tglPenetapan);
            
            return response()->json(array(
                "success" => true,
                "message" => null,
                "data" => $result
            ));

        } catch (\Throwable $th) {
            return response()->json(array(
                "success" => false,
                "message" => $th->getMessage(),
            ));
        }
    }
}
