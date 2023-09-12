<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class ProdukController extends Controller
{
    public function index(Request $request) : Response | JsonResponse
    {

        if ($request->ajax()) {
            $produk = Produk::select("*");
            return DataTables::of($produk)
                    ->addIndexColumn()
                    ->editColumn('jenis', function (Produk $produk) {
                       return ($produk->jenis == true ) ? "Barang Jadi" : "Barang Mentah";
                    })
                    ->addColumn('action', function($produk){
                        $icon = "check";
                        $btn = "";
                        if(!request()->hasHeader("X-SRC-Produk")) {
                            $btn = $btn ."<a id='$produk->kode_produk' class='hapusProduk btn btn-danger'><i class='align-middle' data-feather='trash'></i></a>";
                            $icon = "edit";
                        }
                        $actionClick = ($icon == "edit") ? "editProduk" : "pilihProduk";

                        $btn = $btn. "<a class='$actionClick btn btn-primary mx-1'
                            data-kode-produk='$produk->kode_produk'
                            data-nama='$produk->nama'
                            data-satuan='$produk->satuan'
                            data-harga='$produk->harga'
                            data-jenis='$produk->jenis'
                            data-gambar='$produk->gambar'
                            data-deskripsi='$produk->deskripsi'
                        ><i class='align-middle' data-feather='$icon'></i></a>";

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return response()->view("produk.produk");
    }

    public function getModalAdd(Request $request) : JsonResponse
    {
        if($request->ajax()) {
            $view = view('produk.produk-add')->render();
            return response()->json( array('success' => true, 'modal'=> $view));
        }
    }

    public function store(Request $request) : JsonResponse
    {
        try {
            $validation = $request->validate([
                'kode_produk' => 'required|unique:produk',
                'nama' => 'required',
                'satuan' => 'required',
                'harga' => 'required|numeric',
                'jenis' => 'required',
                'gambar' => "image|mimes:jpeg,png,jpg,gif,svg|max:2048|unique:produk",
                'deskripsi' => ''
            ]);
            $validation["gambar"] = "";
            if($request->file()) {
                $fileName = $request->file("gambar")->getClientOriginalName();
                $validation["gambar"] = $fileName;
                $request->file('gambar')->storeAs('photos/produk', $fileName, 'public');
            }
            $result = Produk::insert($validation);
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
            $view = view('produk.produk-edit')->render();
            return response()->json( array('success' => true, 'modal'=> $view));
        }
    }

    public function update(Request $request, $kode_produk) : JsonResponse
    {
        $produk = Produk::find($kode_produk);

        if($produk == null) abort(404);

        $path = "photos/produk/";
        try {
            $validation = $request->validate([
                'kode_produk' => 'required',
                'nama' => 'required',
                'satuan' => 'required',
                'harga' => 'required|numeric',
                'jenis' => 'required',
                'gambar' => "image|mimes:jpeg,png,jpg,gif,svg|max:2048",
                'description' => ''
            ]);
            // Not Upload Image
            if($request->file("gambar") != null) {
                $inputFile  = $request->file("gambar");
                $fileName = $inputFile->getClientOriginalName();
                    if($fileName != $produk->gambar) {
                        // Update Image
                        Storage::delete($path . $produk->gambar);

                        $name = $inputFile->getClientOriginalName();
                        $inputFile->storePubliclyAs("photos/produk", $name , "public");

                        $validation["gambar"] = $name;
                    } else {
                        // Old Image
                        $validation["gambar"] = $produk->gambar;
                    }
                } else {
                    $validation["gambar"] = "";
                    Storage::disk("public")->delete($path . $produk->gambar);
                }

                    $produk->fill($validation);
                    $produk->update();
                if ($produk) {
                    return response()->json(["success" => "Success Update {$kode_produk}"]);
                }
            } catch (ValidationException $exception) {
                $response = $exception->validator->errors()->toArray();
                return response()->json(["error" => $response]);
            }
    }

    public function delete(Request $request, $kode_produk) : JsonResponse
    {
        if($request->ajax()){
            $produk = Produk::find($kode_produk);
            $path = "photos/produk/";
            $file_path = $path . $produk->gambar;
            if($produk->image != null) {
                Storage::disk("public")->delete($file_path);
            }
            $query = $produk->delete();
            if($query) {
                return response()->json(["success" => "Berhasil Dihapus"]);
            }
            return response()->json(["error" => "Gagal"]);
        }
    }
}
