<?php
namespace App\Repository;

interface StokRepository {
    public function findByLockGudangProduk($id_gudang, $kode_produk);

    public function insert(array $array);

    public function update($id_gudang, $kode_produk, array $array);
}
