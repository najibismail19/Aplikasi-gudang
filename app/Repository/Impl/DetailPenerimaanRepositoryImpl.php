<?php
namespace App\Repository\Impl;

use App\Models\DetailPenerimaan;
use App\Repository\DetailPenerimaanRepository;

Class DetailPenerimaanRepositoryImpl implements DetailPenerimaanRepository {
    public function insert(array $array)
    {
        DetailPenerimaan::insert($array);
    }

    public function getDetailPenerimaan($no_penerimaan)
    {
        return DetailPenerimaan::with(["produk"])->where("no_penerimaan", $no_penerimaan)->get();
    }
}
