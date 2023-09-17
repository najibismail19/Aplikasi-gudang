<?php

namespace App\Http\Controllers;

use App\Repository\StokRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StokController extends Controller
{

    private StokRepository $stok;

    public function __construct(StokRepository $stok)
    {
        $this->stok = $stok;
    }

    public function barangJadi(Request $request) : Response | JsonResponse
    {

        if($request->ajax()) {
            return $this->stok->getDatatable(true);
        }

        return response()->view("stok.barang-jadi");
    }

    public function barangMentah(Request $request) : Response | JsonResponse
    {

        if($request->ajax()) {
            return $this->stok->getDatatable(false);
        }

        return response()->view("stok.barang-mentah");
    }
}
