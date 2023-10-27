<?php
namespace App\Repository;

use Illuminate\Http\JsonResponse;

interface PenjualanRepository {

    public function getDatatable() : JsonResponse;

    public function getByDetailPenjualanComplete($no_penjualan);

    public function ByDateBetween($start, $end);

    public function BygetMostPopularProducts($start, $end, $row);

    public function insert($data);

    public function delete($no_penjualan);

    public function findByNoPenjualan($no_penjualan);

    public function find($no_penjualan);

    public function insertPivotDetailPejualan($no_penjualan, $kode_produk, array $content);

    public function updatePivotDetailPenjualan($no_penjualan, $kode_produk, array $content);

    public function update($no_penjualan, array $content);
}
