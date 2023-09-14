<?php

namespace App\Http\Controllers;

use App\Repository\ProdukRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProdukController extends Controller
{
    private ProdukRepository $produk;

    public function __construct(ProdukRepository $produk) {
        $this->produk = $produk;
    }

    public function index(Request $request) : Response | JsonResponse
    {

        if ($request->ajax()) {
            return $this->produk->getDatatable();
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

            // Insert Produk Repository
            $this->produk->insert($validation);
            return response()->json(["success" => "Berhasil Menambah Produk"]);

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
        $produk = $this->produk->find($kode_produk);

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

            $produk = $this->produk->find($kode_produk);
            $path = "photos/produk/";
            $file_path = $path . $produk->gambar;

            if($produk->image != null) {
                Storage::disk("public")->delete($file_path);
            }

            $this->produk->delete($kode_produk);

            return response()->json(["success" => "Berhasil Dihapus"]);
        }
    }
}
