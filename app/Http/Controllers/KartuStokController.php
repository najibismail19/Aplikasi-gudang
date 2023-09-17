<?php

namespace App\Http\Controllers;

use App\Repository\KartuStokRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class KartuStokController extends Controller
{
    private KartuStokRepository $kartuStok;

    public function __construct(KartuStokRepository $kartuStok)
    {
        $this->kartuStok = $kartuStok;
    }

    public function index(Request $request) : Response | JsonResponse
    {
        if($request->ajax())
        {
            return $this->kartuStok->getDatatable();
        }
        return response()->view("kartu-stok.kartu-stok");
    }
}
