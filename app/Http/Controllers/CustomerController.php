<?php

namespace App\Http\Controllers;

use App\Repository\CustomerRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
{
    private CustomerRepository $customer;

    public function __construct(CustomerRepository $customer)
    {
        $this->customer = $customer;
    }

    public function index(Request $request) : Response | JsonResponse
    {
        if($request->ajax())
        {
            return $this->customer->getDatatable();
        }

        return response()->view("customers.customers");
    }

    public function getModalAdd(Request $request) : JsonResponse
    {
        if($request->ajax()) {
            $view = view('customers.customer-add')->render();
            return response()->json( array('success' => true, 'modal'=> $view));
        }
    }

    public function getModalEdit(Request $request) : JsonResponse
    {
        if($request->ajax()) {
            $view = view('customers.customer-edit')->render();
            return response()->json( array('success' => true, 'modal'=> $view));
        }
    }

    public function store(Request $request) : JsonResponse
    {
        try {
            $validation = $request->validate([
                'id_customer' => 'required|unique:customers',
                'nama' => 'required',
                'kontak' => 'required|numeric',
                'alamat' => 'required',
                'email' => 'required',
                'deskripsi' => 'nullable'
            ]);

            $this->customer->insert($validation);

            return response()->json(["success" => "Berhasil Menambah Produk"]);

        } catch(ValidationException $exception) {
            $response = $exception->validator->errors()->toArray();
            return response()->json(["error" => $response]);
        }
    }

    public function update(Request $request) : JsonResponse
    {
        $customer = $this->customer->find($request->input("id_customer"));

        if($customer == null) abort(404);

        try {
            $validation = $request->validate([
                'nama' => 'required',
                'kontak' => 'required|numeric',
                'alamat' => 'required',
                'email' => 'required',
                'deskripsi' => 'nullable'
            ]);

            $this->customer->update($customer->id_customer, $validation);

            return response()->json(["success" => "Success Update Data Customer"]);

            } catch (ValidationException $exception) {
                $response = $exception->validator->errors()->toArray();
                return response()->json(["error" => $response]);
            }
    }

    public function delete(Request $request, $id_customer) : JsonResponse
    {
        if($request->ajax()){

            $produk = $this->customer->find($id_customer);

            if(is_null($produk)) {

                return response()->json(["error" => "Data Customer Gagal Di Hapus!"]);

            }

            $this->customer->delete($id_customer);

            return response()->json(["success" => "Data Customer Berhasil Dihapus"]);
        }
    }
}
