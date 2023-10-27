<?php

namespace App\Http\Controllers;

use App\Repository\ProdukRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\File;

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
                $request->file('gambar')->move(public_path('storage/photos/produk'), $fileName);
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

    public function update(Request $request) : JsonResponse
    {
        $produk = $this->produk->find($request->input("kode_produk"));

        if($produk == null) abort(404);

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

            // Upload Image

            if($request->file("gambar") != null) {
                $inputFile  = $request->file("gambar");

                $fileName = $inputFile->getClientOriginalName();
                    if($fileName != $produk->gambar) {

                        $imagePath = public_path('storage/photos/produk/' . $produk->gambar);
                        // Memeriksa apakah file ada sebelum dihapus
                        if (File::exists($imagePath) && $produk->gambar != "default.png") {
                            // Menghapus file
                            File::delete($imagePath);
                        }

                        $name =  date("i") . $inputFile->getClientOriginalName();

                        $inputFile->move(public_path('storage/photos/produk'), $name);

                        $validation["gambar"] = $name;
                    } else {
                        // Old Image
                        $validation["gambar"] = $produk->gambar;
                    }
                } else {

                    $validation["gambar"] = "default.png";

                    $imagePath = public_path('storage/photos/produk/' . $produk->gambar);

                    if (File::exists($imagePath) && $produk->gambar != "default.png") {
                        // Menghapus file
                        File::delete($imagePath);
                    }
                }

                    $produk->fill($validation);
                    $produk->update();
                if ($produk) {
                    return response()->json(["success" => "Success Update {$produk->kode_produk}"]);
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
