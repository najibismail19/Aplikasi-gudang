<?php

namespace App\Http\Controllers;

use App\Repository\MasterPrakitanRepository;
use App\Repository\PrakitanRepository;
use Illuminate\Http\Request;

class DetailPrakitanController extends Controller
{
    private PrakitanRepository $prakitan;
    private MasterPrakitanRepository $masterPrakitan;


    public function __construct(PrakitanRepository $prakitan, MasterPrakitanRepository $masterPrakitan) {
        $this->prakitan = $prakitan;
        $this->masterPrakitan = $masterPrakitan;
    }

    public function index(Request $request, $no_prakitan)
    {
        $prakitan = $this->prakitan->find($no_prakitan);
        $detail_prakitan = $this->masterPrakitan->getDetailMasterIsActive($prakitan->kode_produk);

        return response()->view("detail-prakitan.detail-prakitan", [
            "detail_prakitan" => $detail_prakitan,
            "qty_rencana" => $prakitan->qty_rencana
        ]);
    }
}
