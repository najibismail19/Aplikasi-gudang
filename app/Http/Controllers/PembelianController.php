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
    public function getNoPembelian()
    {
        $time = explode("-", date("Y-m-d"));
        $time = implode($time);
        $time = substr($time, 2, 6);
        $purchase = DB::table('pembelian')
             ->select(DB::raw('substr(no_pembelian, 4, 6) as no, no_pembelian'))
             ->where(DB::raw('substr(no_pembelian, 4, 6)'), "=", $time)
             ->get();
        if($purchase != null) {
            $no = (int) substr($purchase[0]->no_pembelian, 9, 4);
            $no++;
            $no_purchase = "PGD" . $time .  sprintf("%04s", $no);
        } else {
            $no_purchase = "PGD" . $time . "0001";
        }
        return $no_purchase;
    }

    public function index(Request $request) : Response | JsonResponse
    {
        if ($request->ajax()) {
            $pembelian = Pembelian::select("*")->with(["karyawan", "supplier"]);
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
                        $btn ="<a class='editpembelian btn btn-primary mx-1'><i class='align-middle' data-feather='edit'></i></a>";
                        $btn = $btn."<a id='$pembelian->no_pembelian' class='hapuspembelian btn btn-danger'><i class='align-middle' data-feather='trash'></i></a>";
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
            "no_pembelian" => $this->getNoPembelian(),
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
