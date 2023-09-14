<?php
namespace App\Repository\Impl;

use App\Models\Produk;
use App\Repository\ProdukRepository;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;

class ProdukRepositoryImpl implements ProdukRepository{

    public function getDatatable(): JsonResponse
    {
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

}
