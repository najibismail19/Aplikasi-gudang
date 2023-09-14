<?php
namespace App\Repository\Impl;

use App\Models\KartuStok;
use App\Repository\KartuStokRepository;

Class KartuStokRepositoryImpl implements KartuStokRepository {

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
