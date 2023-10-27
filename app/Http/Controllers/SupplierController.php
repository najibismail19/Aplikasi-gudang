<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class SupplierController extends Controller
{
    public function index(Request $request) : Response | JsonResponse
    {
        if ($request->ajax()) {
            $supplier = Supplier::select("*");
            return DataTables::of($supplier)
                    ->addIndexColumn()
                    ->addColumn('action', function($supplier){
                        $btn = "";
                            $btn = $btn ."<a id='$supplier->id_supplier' class='hapusSupplier btn btn-danger'><i class='align-middle' data-feather='trash'></i></a>";
                            $btn =  $btn . "<a class='editSupplier btn btn-primary mx-1'
                                            data-id_supplier ='$supplier->id_supplier'
                                            data-nama ='$supplier->nama'
                                            data-kontak ='$supplier->kontak'
                                            data-alamat ='$supplier->alamat'
                                            data-deskripsi ='$supplier->deskripsi'
                            ><i class='align-middle' data-feather='edit'></i></a>";

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return response()->view("supplier.supplier");
    }

    public function getModalAdd(Request $request) : JsonResponse
    {
        if($request->ajax()) {
            $view = view('supplier.supplier-add')->render();
            return response()->json( array('success' => true, 'modal'=> $view));
        }
    }

    public function store(Request $request) : JsonResponse
    {
        try {
            $validation = $request->validate([
                'id_supplier' => 'required|unique:supplier',
                'nama' => 'required',
                'kontak' => 'required|numeric',
                'alamat' => 'required',
                'deskripsi' => ''
            ]);
            $result = Supplier::insert($validation);
            if($result){
                return response()->json(["success" => "Berhasil Menambah Produk"]);
            }
        } catch(ValidationException $exception) {
            $response = $exception->validator->errors()->toArray();
            return response()->json(["error" => $response]);
        }
    }

    public function getModalEdit(Request $request) : JsonResponse
    {
        if($request->ajax()) {
            $view = view('supplier.supplier-edit')->render();
            return response()->json( array('success' => true, 'modal'=> $view));
        }
    }

    public function update(Request $request, $id_supplier) : JsonResponse
    {
        $supplier = Supplier::find($id_supplier);
            if($supplier == null) abort(404);

        try {
            $validation = $request->validate([
                'id_supplier' => 'required',
                'nama' => 'required',
                'kontak' => 'required|numeric',
                'alamat' => 'required',
                'deskripsi' => ''
            ]);
                $supplier->fill($validation);
                $supplier->update();

                return response()->json(["success" => "Supplier Berhasil Di Update"]);
            } catch (ValidationException $exception) {
                $response = $exception->validator->errors()->toArray();
                return response()->json(["error" => $response]);
            }
    }

    public function delete(Request $request, $id_supplier) : JsonResponse
    {
        if($request->ajax()){
            $produk = Supplier::find($id_supplier);

            if($produk == null) abort(404);

            $query = $produk->delete();

            if($query) {
                return response()->json(["success" => "Berhasil Dihapus"]);
            }

            return response()->json(["error" => "Gagal"]);
        }
    }
}
