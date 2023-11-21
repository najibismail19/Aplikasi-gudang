<?php
namespace App\Repository\Impl;

use App\Models\MasterPrakitan;
use App\Models\Produk;
use App\Repository\MasterPrakitanRepository;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;

class MasterPrakitanRepositoryImpl implements MasterPrakitanRepository{

    public function getAll()
    {
        $groupProduk = MasterPrakitan::select("kode_produk_jadi")->groupBy("kode_produk_jadi")->get();
        $kode_produk = [];
        foreach($groupProduk as $produk) {
            array_push($kode_produk, $produk->kode_produk_jadi);
        }

        return Produk::select("*")->whereIn("kode_produk", $kode_produk)->get();
    }

    public function getDatatable(): JsonResponse
    {
        return DataTables::of($this->getAll())
            ->addIndexColumn()
            ->editColumn('jenis_produk', function (Produk $produk) {
                return ($produk->jenis == 1) ? "Barang Jadi" : "Barang Mentah";
            })
            ->addColumn('action', function($produk){
                return "<a href='/master-prakitan/$produk->kode_produk'class='btn btn-secondary mx-1' id='$produk->kode_produk'><i class='fas fa-eye'></i></a>";
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getDetailMaster($kode_produk_jadi)
    {
        return MasterPrakitan::select("*")->with(["produk_jadi", "produk_mentah"])
                                          ->where("kode_produk_jadi", $kode_produk_jadi)
                                          ->where("is_active", false)
                                          ->get();
    }

    public function getDetailMasterIsActive($kode_produk_jadi)
    {
        return MasterPrakitan::select("*")->with(["produk_jadi", "produk_mentah"])
                                          ->where("kode_produk_jadi", $kode_produk_jadi)
                                          ->where("is_active", true)
                                          ->get();
    }

    public function insert(array $array)
    {
        MasterPrakitan::insert($array);
    }



    public function update($kode_produk_jadi, $kode_produk_mentah, array $array)
    {
        MasterPrakitan::where("kode_produk_jadi", $kode_produk_jadi)
                        ->where("kode_produk_mentah", $kode_produk_mentah)
                        ->update($array);
    }

    public function delete($kode_produk_jadi, $kode_produk_mentah)
    {
        return MasterPrakitan::where("kode_produk_jadi", $kode_produk_jadi)
                        ->where("kode_produk_mentah", $kode_produk_mentah)
                        ->delete();
    }

    public function updateManyIsActive($kode_produk_jadi)
    {
        return MasterPrakitan::where("kode_produk_jadi", $kode_produk_jadi)
                            ->update([
                                "is_active" => true
                            ]);
    }
}
