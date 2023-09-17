<?php
namespace App\Repository\Impl;

use App\Models\KartuStok;
use App\Repository\KartuStokRepository;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

Class KartuStokRepositoryImpl implements KartuStokRepository {


    public function getDatatable() : JsonResponse
    {
        $data = KartuStok::select("*")->with(["produk", "gudang"]);
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('gudang', function (KartuStok $kartuStok) {
                return $kartuStok->gudang->nama_gudang;
            })
            ->editColumn('jenis_produk', function (KartuStok $kartuStok) {
                return ($kartuStok->produk->jenis == 0) ? "Barang Jadi" : "Barang Mentah";
            })
            ->editColumn('tanggal', function (KartuStok $kartuStok) {
                return Carbon::parse($kartuStok->tanggal)->isoFormat('dddd, D MMMM Y');
            })
            ->editColumn('nama_produk', function (KartuStok $kartuStok) {
                return $kartuStok->produk->nama;
            })
            ->make(true);
    }

    public function findByLockGudangProduk($id_gudang, $kode_produk)
    {
        return KartuStok::select("*")
                        ->where("id_gudang", $id_gudang)
                        ->where("kode_produk", $kode_produk)
                        ->orderBy('tanggal', 'desc')
                        ->lockForUpdate()
                        ->first();
    }

    public function insert(array $array)
    {
        KartuStok::insert($array);
    }

}
