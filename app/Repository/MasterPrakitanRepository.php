<?php
namespace App\Repository;

use Illuminate\Http\JsonResponse;

interface MasterPrakitanRepository {
    public function getDatatable(): JsonResponse;

    public function getDetailMaster($kode_produk_jadi);

    public function getDetailMasterIsActive($kode_produk_jadi);

    public function insert(array $array);

    public function update($kode_produk_jadi, $kode_produk_mentah, array $array);

    public function delete($kode_produk_jadi, $kode_produk_mentah);

    public function updateManyIsActive($kode_produk_jadi);
}
