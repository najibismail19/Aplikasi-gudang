<?php
namespace App\Repository;

use Illuminate\Http\JsonResponse;

Interface PembelianRepository {

    public function getDatatable() : JsonResponse;

    public function insert($data);

    public function find($no_pembelian);

    public function update($no_pembelian, array $content);

    public function insertPivotDetailPembelian($no_pembelian, $kode_produk, array $content);

    public function updatePivotDetailPembelian($no_pembelian, $kode_produk, array $content);

    public function deletePivotDetailPembelian($no_pembelian, $kode_produk);

}
