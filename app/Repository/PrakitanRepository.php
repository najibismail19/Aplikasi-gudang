<?php
namespace App\Repository;

use Illuminate\Http\JsonResponse;

interface PrakitanRepository {

    public function getDatatable() : JsonResponse;

    public function insert(array $data);

    public function update($no_prakitan, array $data);

    public function find($no_prakitan);

    public function insertPivotDetailPrakitan($no_prakitan, $kode_produk, array $content);

    public function updatePivotDetailPrakitan($no_prakitan, $kode_produk, array $content);
}
