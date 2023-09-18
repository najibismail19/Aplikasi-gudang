<?php
namespace App\Repository\Impl;

use App\Models\Stok;
use App\Repository\StokRepository;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

Class StokRepositoryImpl implements StokRepository {

    public function getDatatable($jenis_produk): JsonResponse
    {
        $data = Stok::join('produk', 'produk.kode_produk', '=', 'stok.kode_produk')
                        ->join('gudang', 'gudang.id_gudang', '=', 'stok.id_gudang')
                        ->where('produk.jenis', $jenis_produk)
                        ->get(['stok.*', 'produk.*', 'gudang.*']);

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('jenis_produk', function (Stok $kartuStok) {
                return ($kartuStok->produk->jenis == 1) ? "Barang Jadi" : "Barang Mentah";
            })
            ->make(true);
    }

    public function findByLockGudangProduk($id_gudang, $kode_produk)
    {
        return Stok::select("*")
                    ->where("id_gudang", $id_gudang)
                    ->where("kode_produk", $kode_produk)
                    ->lockForUpdate()
                    ->first();
    }

    public function findByGudangProduk($id_gudang, $kode_produk)
    {
        return Stok::select("*")
                    ->where("id_gudang", $id_gudang)
                    ->where("kode_produk", $kode_produk)
                    ->first();
    }

    public function insert(array $array)
    {
        Stok::insert($array);
    }

    public function update($id_gudang, $kode_produk, array $array)
    {
        Stok::where("id_gudang", $id_gudang)->where("kode_produk", $kode_produk)->update($array);
    }

}

