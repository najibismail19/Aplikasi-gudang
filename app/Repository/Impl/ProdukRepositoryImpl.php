<?php
namespace App\Repository\Impl;

use App\Models\Produk;
use App\Repository\ProdukRepository;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;

class ProdukRepositoryImpl implements ProdukRepository{

    public function getDatatable(): JsonResponse
    {
        $filter_jenis["jenis_produk"] = false;
        if(request()->hasHeader("X-SRC-PRK-Produk")){
            $filter_jenis["jenis_produk"] = request()->header("X-SRC-PRK-Produk");
        };
        $produk = Produk::select("*")->filter(filter : $filter_jenis);
        return DataTables::of($produk)
                ->addIndexColumn()
                ->editColumn('jenis', function (Produk $produk) {
                   return ($produk->jenis == true ) ? "Barang Jadi" : "Barang Mentah";
                })
                ->editColumn('harga', function (Produk $produk) {
                   return 'Rp '.number_format($produk->harga, 0, ',', '.');
                })
                ->addColumn('action', function($produk){
                    $btn = "";
                    $btn = $btn ."<a
                                        data-image='$produk->gambar'
                                        data-kode_produk='$produk->kode_produk'
                                        data-nama='$produk->nama'
                     class='showImage btn btn-success mx-1'><i class='fas fa-eye'></i></a>";
                    $btn = $btn ."<a id='$produk->kode_produk' class='hapusProduk btn btn-danger'><i class='fas fa-trash'></i></a>";
                    $btn = $btn. "<a class='editProduk btn btn-primary mx-1'
                        data-kode-produk='$produk->kode_produk'
                        data-nama='$produk->nama'
                        data-satuan='$produk->satuan'
                        data-harga='$produk->harga'
                        data-jenis='$produk->jenis'
                        data-gambar='$produk->gambar'
                        data-deskripsi='$produk->deskripsi'
                    ><i class='fas fa-edit'></i></a>";

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function insert($data)
    {
        Produk::insert($data);
    }

    public function find($kode_produk) : ?Produk
    {
        $produk = Produk::find($kode_produk);
        if($produk) {
            return $produk;
        }
        return null;
    }

    public function delete($kode_produk)
    {
        Produk::destroy($kode_produk);
    }

    public function getAll()
    {
        return Produk::all();
    }
}
