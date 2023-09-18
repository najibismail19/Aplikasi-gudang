<?php
namespace App\Repository;

interface PrakitanRepository {
    public function insert(array $data);

    public function find($no_prakitan);

    public function insertPivotDetailPrakitan($no_prakitan, $kode_produk, array $content);
}
