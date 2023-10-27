<?php
namespace App\Repository;

use Illuminate\Http\JsonResponse;

interface CustomerRepository {

    public function getDatatable() : JsonResponse;

    public function update($id_customer, array $content);

    public function getAll();

    public function insert($data);

    public function find($id_customer);

    public function delete($id_customer);

}
