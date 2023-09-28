<?php
namespace App\Repository;

interface DetailPenerimaanRepository {
        public function insert(array $array);

        public function getDetailPenerimaan($no_penerimaan);
}
