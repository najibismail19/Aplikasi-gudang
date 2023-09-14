<?php
namespace App\Repository;

interface KartuStokRepository {
        public function findByLockGudangProduk($id_gudang, $kode_produk);

        public function insert(array $array);
}
