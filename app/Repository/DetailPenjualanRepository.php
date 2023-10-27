<?php
namespace App\Repository;

use Illuminate\Http\JsonResponse;

interface DetailPenjualanRepository {

    public function sum($no_penjualan);

    public function findByNoPenjualan($no_penjualan);

    public function ByNoPenjualanKodeProduk($no_penjualan, $kode_produk);

    public function ByNoPenjualan($no_penjualan);

    public function deleteByNoPenjualanKodeProduk($no_penjualan, $kode_produk);
}
