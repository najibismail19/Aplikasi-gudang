<?php
namespace App\Repository\Impl;

use App\Models\Stok;
use App\Repository\StokRepository;
use Illuminate\Support\Facades\DB;

Class StokRepositoryImpl implements StokRepository {

    public function findByLockGudangProduk($id_gudang, $kode_produk)
    {
        return Stok::select("*")
                    ->where("id_gudang", $id_gudang)
                    ->where("kode_produk", $kode_produk)
                    ->lockForUpdate()
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

