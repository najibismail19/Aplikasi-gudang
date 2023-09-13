<?php

namespace App\Http\Controllers;

use App\Models\DetailPembelian;
use App\Models\DetailPenerimaan;
use App\Models\Pembelian;
use App\Models\Penerimaan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PenerimaanController extends Controller
{
    public function index(Request $request) : Response | JsonResponse
    {
        if ($request->ajax()) {
            $penerimaan = Penerimaan::select("*")->with(["karyawan", "pembelian"]);
            return DataTables::of($penerimaan)
                    ->addIndexColumn()
                    ->editColumn('karyawan', function (Penerimaan $penerimaan) {
                        return $penerimaan->karyawan->nama;
                    })
                    ->editColumn('tanggal', function (Penerimaan $penerimaan) {
                        return Carbon::parse($penerimaan->tanggal_penerimaan)->isoFormat('dddd, D MMMM Y');
                    })
                    ->addColumn('action', function($penerimaan){
                        $btn ="<a class='editpembelian btn btn-primary mx-1'><i class='align-middle' data-feather='edit'></i></a>";
                        $btn = $btn."<a id='$penerimaan->no_penerimaan' class='hapuspembelian btn btn-danger'><i class='align-middle' data-feather='trash'></i></a>";
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return response()->view("penerimaan.penerimaan");
    }

    public function tambahPenerimaan()
    {
        return response()->view("penerimaan.penerimaan-tambah",[
            "no_penerimaan" => generateNo(code : "PNN", table : "penerimaan"),
            "karyawan" => Auth::guard("karyawan")->user()
        ]);
    }

    public function searchPenerimaan(Request $request) : JsonResponse
    {
        $view = view('penerimaan.search-pembelian')->render();
        return response()->json( array('success' => true, 'modal'=> $view));
    }

    public function getDetailPembelian(Request $request, $no_pembelian) : array
    {
        if ($request->ajax()) {

            $pembelian = Pembelian::find($no_pembelian);
            $pembelian = [
                "no_pembelian" => $pembelian->no_pembelian,
                "nama_supplier" => $pembelian->supplier->nama,
                "tanggal_pembelian" => $pembelian->tanggal_pembelian,
                "karyawan_input" => $pembelian->karyawan->nama,
                "total_produk" => count($pembelian->detailPembelian),
                "total_keseluruhan" => $pembelian->total_keseluruhan,
            ];


            $detail_pembelian = DetailPembelian::with(["produk"])->where("no_pembelian", $no_pembelian)->get();
            $array = [];
            foreach($detail_pembelian as $detail) {
                $array[] = [
                    "kode_produk" => $detail->kode_produk,
                    "nama_produk" => $detail->produk->nama,
                    "jumlah"  => $detail->jumlah,
                    "harga" => $detail->harga,
                    "total_harga" => $detail->total_harga,
                ];
            }

            return ["pembelian" => $pembelian,"detail_pembelian" => $array];
        }
    }

    public function store(Request $request) {
        if($request->ajax()) {
            $no_pembelian = $request->input("no_pembelian");

            $pembelian = Pembelian::find($no_pembelian);
            $pembelian->status_penerimaan = true;
            $pembelian->update();

            $detail_penerimaan = [];
            foreach($pembelian->detailPembelian as $detail) {
                $pivot = $detail->pivot;
                $detail_penerimaan[] = [
                    "no_penerimaan" => $request->input("no_penerimaan"),
                    "kode_produk" => $pivot->kode_produk,
                    "jumlah" => $pivot->jumlah
                ];
            }

            Penerimaan::insert([
                "no_penerimaan" => $request->input("no_penerimaan"),
                "no_pembelian" => $request->input("no_pembelian"),
                "nik" => $request->input("nik"),
                "tanggal_penerimaan" => $request->input("tanggal_penerimaan"),
                "deskripsi" => $request->input("deskripsi")
            ]);
            DetailPenerimaan::insert($detail_penerimaan);
        }
    }
}
