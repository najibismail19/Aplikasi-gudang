<?php
namespace App\Repository\Impl;

use App\Models\Customer;
use Yajra\DataTables\DataTables;
use App\Repository\CustomerRepository;
use Illuminate\Http\JsonResponse;

Class CustomerRepositoryImpl implements CustomerRepository{

    public function getDatatable(): JsonResponse
    {
        $customers = Customer::select("*");
        return DataTables::of($customers)
                ->addIndexColumn()

                ->addColumn('action', function($customer){
                    $btn = "";

                    $btn = $btn ."<a id='$customer->id_customer' class='hapusCustomer btn btn-danger mx-2'><i class='align-middle' data-feather='trash'></i></a>";

                    $btn = $btn ."<a id='$customer->id_customer'
                                        data-id_customer='{$customer->id_customer}'
                                        data-nama='{$customer->nama}'
                                        data-kontak='{$customer->kontak}'
                                        data-alamat='{$customer->alamat}'
                                        data-email='{$customer->email}'
                                        data-deskripsi='{$customer->deskripsi}'
                    class='editCustomer btn btn-primary'><i class='align-middle' data-feather='edit'></i></a>";

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function insert($data)
    {
        Customer::insert($data);
    }

    public function find($id_customer) : ?Customer
    {
        $customer = Customer::find($id_customer);
        if($customer) {
            return $customer;
        }
        return null;
    }

    public function delete($id_customer)
    {
        Customer::destroy($id_customer);
    }

    public function getAll()
    {
        return Customer::all();
    }

    public function update($id_customer, array $content) {

        $customer = $this->find($id_customer);

        $customer->fill($content);

        $customer->update();
    }
}
