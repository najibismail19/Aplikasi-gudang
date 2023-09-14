<?php
namespace App\Repository;

use Illuminate\Http\JsonResponse;
use App\Models\Produk;

interface ProdukRepository {

    public function getDatatable() : JsonResponse;

    public function insert($data);

    public function find($kode_produk);

    public function delete($kode_produk);
}

