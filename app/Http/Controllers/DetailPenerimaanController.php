<?php

namespace App\Http\Controllers;

use App\Repository\DetailPembelianRepository;
use App\Repository\DetailPenerimaanRepository;
use App\Repository\PenerimaanRepository;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DetailPenerimaanController extends Controller
{
    private PenerimaanRepository $penerimaan;

    private DetailPembelianRepository $detalPembelian;

    public function __construct(DetailPembelianRepository $detalPembelian, PenerimaanRepository $penerimaan)
    {
        $this->penerimaan = $penerimaan;

        $this->detalPembelian = $detalPembelian;
    }

    public function showDetail($no_penerimaan, Request $request)
    {

        $penerimaan = $this->penerimaan->findByNoPenerimaan($no_penerimaan);

        return response()->view("detail_penerimaan.show_detail_penerimaan", [
            "penerimaan" => $penerimaan,
            "tanggal_penerimaan" => Carbon::parse($penerimaan->tanggal_penerimaan)->isoFormat('D MMMM Y'),
            "detail_penerimaan" => $this->detalPembelian->findByNoPembelian($penerimaan->no_pembelian)->get()
        ]);
    }
}
