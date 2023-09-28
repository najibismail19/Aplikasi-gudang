<?php

namespace App\Http\Controllers;

use App\Repository\KartuStokRepository;
use App\Repository\MasterPrakitanRepository;
use App\Repository\PrakitanRepository;
use App\Repository\StokRepository;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DetailPrakitanController extends Controller
{
    private PrakitanRepository $prakitan;

    private MasterPrakitanRepository $masterPrakitan;

    private StokRepository $stok;

    private KartuStokRepository $kartuStok;


    public function __construct(PrakitanRepository $prakitan, MasterPrakitanRepository $masterPrakitan, StokRepository $stok, KartuStokRepository $kartuStok) {

        $this->prakitan = $prakitan;

        $this->masterPrakitan = $masterPrakitan;

        $this->stok = $stok;

        $this->kartuStok = $kartuStok;
    }

    public function index(Request $request, $no_prakitan)
    {
        $prakitan = $this->prakitan->find($no_prakitan);

        if($prakitan == null || $prakitan->nik != getNik() || $prakitan->qty_hasil != null || $prakitan->tanggal_actual_prakitan != null) {
            return abort(404);
        }

        $detail_prakitan = $this->masterPrakitan->getDetailMasterIsActive($prakitan->kode_produk);

        return response()->view("detail-prakitan.detail-prakitan", [
            "detail_prakitan" => $detail_prakitan,
            "prakitan" => $prakitan,
            "tanggal_rencana" => Carbon::parse($prakitan->tanggal_rencana)->format("Y-m-d"),
        ]);
    }

    public function store(Request $request) : JsonResponse
    {
        if($request->ajax()) {
            try {
                DB::beginTransaction();

                $prakitan = $this->prakitan->find(request()->input("no_prakitan"));

                $detail_prakitan = $this->masterPrakitan->getDetailMasterIsActive($prakitan->kode_produk);

                $detail_prakitan->each( function ($detail) use ($request) {

                $cek_qty = ($detail->quantity * $request->input("qty_rencana")) - ($detail->quantity * $request->input("qty_hasil"));

                    if($cek_qty > 0) {
                        $kartu_stock = $this->kartuStok->findByGudangProduk(getIdGudang(), $detail->kode_produk_mentah);

                        if($kartu_stock) {

                            $dataKartuStok = [
                                    "id_gudang" => getIdGudang(),
                                    "kode_produk" => $detail->kode_produk_mentah,
                                    "no_referensi" => $request->input("no_prakitan"),
                                    "saldo_awal" => $kartu_stock->saldo_akhir,
                                    "stock_in" => $cek_qty,
                                    "stock_out" => 0,
                                    "saldo_akhir" => DB::raw("saldo_awal - $cek_qty"),
                                    "deskripsi" => "Pengembalin prakitan"
                                ];

                            $this->kartuStok->insert($dataKartuStok);

                        }


                        $this->stok->update(getIdGudang(), $detail->kode_produk_mentah, [
                            "stok" => DB::raw("stok + $cek_qty")
                        ]);


                        }

                    $this->prakitan->updatePivotDetailPrakitan($request->no_prakitan, $detail->kode_produk_mentah, [
                        "qty" => $detail->quantity * $request->input("qty_hasil")
                    ]);

                });

                $stok = $this->stok->findByGudangProduk(getIdGudang(), $request->input("kode_produk"));
                if($stok) {
                    $this->stok->update($stok->id_gudang, $stok->kode_produk, [
                        "stok" => DB::raw("stok + {$request->input("qty_hasil")}")
                    ]);
                } else {
                    $this->stok->insert([
                        "id_gudang" => getIdGudang(),
                        "kode_produk" => $request->input("kode_produk"),
                        "stok" => $request->input("qty_hasil")
                    ]);
                }

                $kartu_stock = $this->kartuStok->findByGudangProduk(getIdGudang(), $request->input("kode_produk"));

                            if($kartu_stock) {
                                $dataKartuStok = [
                                        "id_gudang" => getIdGudang(),
                                        "kode_produk" => $request->input("kode_produk"),
                                        "no_referensi" => $request->input("no_prakitan"),
                                        "saldo_awal" => $kartu_stock->saldo_akhir,
                                        "stock_in" => $request->input("qty_hasil"),
                                        "stock_out" => 0,
                                        "saldo_akhir" => DB::raw("saldo_awal + stock_in"),
                                        "deskripsi" => ""
                                    ];
                                $this->kartuStok->insert($dataKartuStok);
                            } else {
                                $dataKartuStok = [
                                    "id_gudang" => getIdGudang(),
                                    "kode_produk" => $request->input("kode_produk"),
                                    "no_referensi" => $request->input("no_prakitan"),
                                    "saldo_awal" => 0,
                                    "stock_in" => $request->input("qty_hasil"),
                                    "stock_out" => 0,
                                    "saldo_akhir" => $request->input("qty_hasil"),
                                    "deskripsi" => ""
                                ];
                            $this->kartuStok->insert($dataKartuStok);
                            }

                $this->prakitan->update($request->input("no_prakitan"), [
                    "tanggal_actual_prakitan" => Carbon::now(),
                    "qty_hasil" => $request->input("qty_hasil")
                ]);
                DB::commit();

                return response()->json(["success" => "Prakitan Berhasil Terselesaikan"]);
            } catch (\Throwable $e) {

                DB::rollBack();

                return response()->json(["error_sql" => $e->getMessage()]);

            }
        }
    }

    public function showDetail($no_prakitan, Request $request)
    {
        $prakitan = $this->prakitan->find($no_prakitan);

        if(!$prakitan) return abort(404);

        $detail_prakitan = $this->masterPrakitan->getDetailMasterIsActive($prakitan->kode_produk);

        return response()->view("detail-prakitan.show_detail_prakitan",[
            "prakitan" => $prakitan,
            "detail_prakitan" => $detail_prakitan,
            "tanggal_rencana" => Carbon::parse($prakitan->tanggal_rencana)->isoFormat("D MMMM Y"),
            "tanggal_actual" => Carbon::parse($prakitan->tanggal_actual_prakitan)->isoFormat("D MMMM Y"),
        ]);

    }
}
