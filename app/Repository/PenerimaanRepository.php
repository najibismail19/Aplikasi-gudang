<?php
namespace App\Repository;

use Illuminate\Http\JsonResponse;

interface PenerimaanRepository {

    public function getDatatable($data) : JsonResponse;

    public function insert(array $array);

    public function all();

    public function findByNoPenerimaan($no_penerimaan);
}
