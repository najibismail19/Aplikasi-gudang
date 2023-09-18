<?php
namespace App\Repository\Impl;

use App\Models\Prakitan;
use App\Repository\PrakitanRepository;

Class PrakitanRepositoryImpl implements PrakitanRepository{

    public function find($no_prakitan)
    {
        $prakitan = Prakitan::find($no_prakitan);
        if($prakitan) {
            return $prakitan;
        }
        return null;
    }

    public function insert(array $data)
    {
        Prakitan::insert($data);
    }

    public function insertPivotDetailPrakitan($no_prakitan, $kode_produk, array $content)
    {
        $pembelian = $this->find($no_prakitan);

        $pembelian->detailPrakitan()->attach($kode_produk, $content);
    }

}
