<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class PembelianController extends Controller
{

    public function index(Request $request) : Response | JsonResponse
    {
        if ($request->ajax()) {
            $filter["status_pembelian"] = false;
            if(request()->hasHeader("X-SRC-Pembelian"))
            {
                $filter["status_pembelian"] = true;
            }
            $pembelian = Pembelian::select("*")->filter(filter : $filter)->with(["karyawan", "supplier"]);
            return DataTables::of($pembelian)
                    ->addIndexColumn()
                    ->editColumn('supplier', function (Pembelian $pembelian) {

                        return $pembelian->supplier->nama;

                    })
                    ->editColumn('karyawan', function (Pembelian $pembelian) {

                        return $pembelian->karyawan->nama;

                    })
                    ->editColumn('total_produk', function (Pembelian $pembelian) {

                        return count($pembelian->detailPembelian);

                    })
                    ->editColumn('tanggal', function (Pembelian $pembelian) {

                        return Carbon::parse($pembelian->tanggal_pembelian)->isoFormat('dddd, D MMMM Y');

                    })
                    ->addColumn('action', function($pembelian){

                        $btn = "";
                        $icon = "check";

                        if(!request()->hasHeader("X-SRC-Pembelian")) {

                            $btn = $btn. "<a id='$pembelian->no_pembelian' class='hapuspembelian btn btn-danger'><i class='align-middle' data-feather='trash'></i></a>";
                            $icon = "edit";

                        }

                        $actionClick = ($icon == 'edit') ? 'editPembelian' : 'pilihPembelian';
                        $btn = $btn . "<a class='$actionClick btn btn-primary mx-1' id='$pembelian->no_pembelian'><i class='align-middle' data-feather='$icon'></i></a>";

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return response()->view("pembelian.pembelian");
    }

    public function tambahPembelian(Request $request) : Response
    {
        return response()->view("pembelian.pembelian-tambah", [
            "no_pembelian" => generateNo(code : "PGD", table : "pembelian"),
            "karyawan" => Auth::guard("karyawan")->user()
        ]);
    }

    public function getModalSupplier(Request $request) : JsonResponse
    {
        if($request->ajax()) {
            $view = view('pembelian.get-modal-supplier')->render();
            return response()->json( array('success' => true, 'modal'=> $view));
        }
    }

    public function store(Request $request) : RedirectResponse
    {
            $pembelian = $request->validate([
                "no_pembelian" => ["required", "unique:pembelian"],
                "nik" => ["required"],
                "id_supplier" => ["required"],
                "tanggal_pembelian" => ["required"],
                "deskripsi" => ["max:255"]
            ]);

            $query = Pembelian::insert($pembelian);
            if($query) {
                return redirect()->route("detail.pembelian", [ "no_pembelian" => $pembelian["no_pembelian"]]);
            }
        }
}
