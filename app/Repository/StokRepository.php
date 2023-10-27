<?php
namespace App\Repository;

use Illuminate\Http\JsonResponse;

interface StokRepository {

    public function getDatatable($jenis_barang) : JsonResponse;

    public function ByDescStok($id_gudang = null, $row);

    public function findByLockGudangProduk($id_gudang, $kode_produk);

    public function findByGudangProduk($id_gudang, $kode_produk);

    public function insert(array $array);

    public function update($id_gudang, $kode_produk, array $array);
}
