<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Repository\PenerimaanRepository;
use App\Repository\PembelianRepository;
use App\Repository\DetailPembelianRepository;
use App\Repository\DetailPenerimaanRepository;
use App\Repository\KartuStokRepository;
use App\Repository\StokRepository;

class PenerimaanController extends Controller
{
    private PembelianRepository $pembelian;

    private DetailPembelianRepository $detailPembelian;

    private PenerimaanRepository $penerimaan;

    private DetailPenerimaanRepository $detailPenerimaan;

    private KartuStokRepository $kartuStok;

    private StokRepository $stok;

    public function __construct(PenerimaanRepository $penerimaan, PembelianRepository $pembelian, DetailPembelianRepository $detailPembelian, DetailPenerimaanRepository $detailPenerimaan, KartuStokRepository $kartuStok, StokRepository $stok) {

        $this->penerimaan = $penerimaan;

        $this->pembelian = $pembelian;

        $this->detailPembelian = $detailPembelian;

        $this->detailPenerimaan = $detailPenerimaan;

        $this->kartuStok = $kartuStok;

        $this->stok = $stok;
    }


    public function index(Request $request) : Response | JsonResponse
    {
        if ($request->ajax()) {

            $data = $this->penerimaan->all();

            return $this->penerimaan->getDatatable($data);

        }

        return response()->view("penerimaan.penerimaan");
    }

    public function tambahPenerimaan() : Response
    {
        return response()->view("penerimaan.penerimaan-tambah",[
            "no_penerimaan" => generateNo(code : "PNN", table : "penerimaan"),
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

            $pembelian = $this->pembelian->find($no_pembelian);
            $pembelian = [
                "no_pembelian" => $pembelian->no_pembelian,
                "nama_supplier" => $pembelian->supplier->nama,
                "tanggal_pembelian" => Carbon::parse($pembelian->tanggal_pembelian)->format("Y-m-d"),
                "karyawan_input" => $pembelian->karyawan->nama,
                "deskripsi" => $pembelian->deskripsi,
                "total_produk" => count($pembelian->detailPembelian),
                "total_keseluruhan" => "Rp. " . number_format($pembelian->total_keseluruhan),
            ];


            $detail_pembelian = $this->detailPembelian->allByNoPembelian($no_pembelian);

            $array = [];

            foreach($detail_pembelian as $detail) {
                $array[] = [
                    "kode_produk" => $detail->kode_produk,
                    "nama_produk" => $detail->produk->nama,
                    "jenis_produk" => $detail->produk->jenis,
                    "jumlah"  => $detail->jumlah,
                    "harga" => $detail->harga,
                    "total_harga" => "Rp. " . number_format($detail->total_harga),
                ];
            }

            return ["pembelian" => $pembelian,"detail_pembelian" => $array];
        }
    }

    public function store(Request $request) : JsonResponse
    {
        if($request->ajax()) {
            $no_pembelian = $request->input("no_pembelian");
            try {
                DB::beginTransaction();
                $pembelian = $this->pembelian->find($no_pembelian);

                $this->pembelian->update($no_pembelian, [
                    "status_penerimaan" => true
                ]);

                $detail_pembelian = $this->detailPembelian->allByNoPembelian($no_pembelian);

                $detail_pembelian->each(function ($detail) use ($request) {

                    $detail_penerimaan = [
                        "no_penerimaan" => $request->input("no_penerimaan"),
                        "kode_produk" => $detail->kode_produk,
                        "jumlah" => $detail->jumlah
                    ];

                    $this->detailPenerimaan->insert($detail_penerimaan);

                    $kartu_stock = $this->kartuStok->findByLockGudangProduk(getIdGudang(), $detail->kode_produk);

                            if($kartu_stock) {
                              $dataKartuStok1 = [
                                    "id_gudang" => getIdGudang(),
                                    "kode_produk" => $detail->kode_produk,
                                    "no_referensi" => $request->input("no_penerimaan"),
                                    "saldo_awal" => $kartu_stock->saldo_akhir,
                                    "stock_in" => $detail->jumlah,
                                    "stock_out" => 0,
                                    "saldo_akhir" => $kartu_stock->saldo_akhir + $detail->jumlah,
                                    "deskripsi" => $request->input("deskripsi")
                                ];

                                $this->kartuStok->insert($dataKartuStok1);

                            } else {

                                $dataKartuStok2 = [
                                    "id_gudang" => getIdGudang(),
                                    "kode_produk" => $detail->kode_produk,
                                    "no_referensi" => $request->input("no_penerimaan"),
                                    "saldo_awal" => 0,
                                    "stock_in" => $detail->jumlah,
                                    "stock_out" => 0,
                                    "saldo_akhir" => $detail->jumlah,
                                    "deskripsi" => $request->input("deskripsi")
                                ];

                                $this->kartuStok->insert($dataKartuStok2);
                            }


                            $stock = $this->stok->findByLockGudangProduk(getIdGudang(), $detail->kode_produk);

                            if($stock){

                                $this->stok->update(getIdGudang(), $detail->kode_produk, [
                                    "stok" => DB::raw("stok + $detail->jumlah")
                                ]);

                            } else {

                                $dataStok = [
                                    "id_gudang" => getIdGudang(),
                                    "kode_produk" => $detail->kode_produk,
                                    "stok" => $detail->jumlah
                                ];

                                $this->stok->insert($dataStok);
                            }
                        });


                $dataPenerimaan = [
                    "no_penerimaan" => $request->input("no_penerimaan"),
                    "no_pembelian" => $request->input("no_pembelian"),
                    "nik" => $request->input("nik"),
                    "tanggal_penerimaan" => $request->input("tanggal_penerimaan"),
                    "deskripsi" => $request->input("deskripsi")
                ];
                $this->penerimaan->insert($dataPenerimaan);
                DB::commit();
                return response()->json(["success" => "Data Pembelian Berhasil Diterima"]);
            } catch (\Throwable $e){
                DB::rollback();
                return response()->json(["error" => "Error 500"]);
            }

        }
    }
}
