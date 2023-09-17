<?php
namespace App\Repository\Impl;

use App\Models\MasterPrakitan;
use App\Repository\MasterPrakitanRepository;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;

class MasterPrakitanRepositoryImpl implements MasterPrakitanRepository{
    public function getDatatable(): JsonResponse
    {

        $data = MasterPrakitan::join('produk', 'produk.kode_produk', '=', 'master_prakitan.kode_produk_jadi')
                        ->where('produk.jenis', 1)
                        ->where('master_prakitan.is_active', 1)
                        ->get(['master_prakitan.*', 'produk.*']);
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('jenis_produk', function (MasterPrakitan $masterPrakitan) {
                return ($masterPrakitan->produk_jadi->jenis == 1) ? "Barang Jadi" : "Barang Mentah";
            })
            ->addColumn('action', function($masterPrakitan){

                $btn = "<a class='btn btn-secondary mx-1' id='$masterPrakitan->kode_produk_jadi'><i class='align-middle' data-feather='eye'></i></a>";

                return $btn;
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
