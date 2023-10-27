<?php
namespace App\Repository;

use App\Models\DetailPembelian;
use Illuminate\Http\JsonResponse;

interface DetailPembelianRepository {
    public function getDatatable($data) : JsonResponse;

    public function findByNoPembelian($no_pembelian);

    // public function ByDateBetween($start, $end);

    public function allByNoPembelian($no_pembelian);

    public function findByNoPembelianKodeProduk($no_pembelian, $kode_produk);

    public function deleteByNoPembelianKodeProduk($no_pembelian, $kode_produk);

    public function sum($no_pembelian);

}
