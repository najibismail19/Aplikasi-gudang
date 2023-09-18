<?php
namespace App\Repository;

use Illuminate\Http\JsonResponse;

interface KartuStokRepository {

        public function getDatatable(): JsonResponse;

        public function findByLockGudangProduk($id_gudang, $kode_produk);

        public function findByGudangProduk($id_gudang, $kode_produk);

        public function insert(array $array);
}
