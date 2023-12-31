<?php
namespace App\Repository\Impl;

use App\Models\KartuStok;
use App\Repository\KartuStokRepository;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

Class KartuStokRepositoryImpl implements KartuStokRepository {


    public function getDatatable() : JsonResponse
    {
        $data = KartuStok::select("*")->with(["produk", "gudang"])->orderBy("tanggal", "asc");
        return DataTables::of($data)
            ->addIndexColumn()


            ->filter(function ($query) {
                // if(request()-> == "all") return true;
                if(trim(request()->input("awal")) != "" && trim(request()->input("akhir")) != ""){
                    $query->whereBetween('tanggal', [request()->input("awal"), request()->input("akhir")]);
                }

                if(trim(request()->input("no_referensi")) != ""){
                    $query->where('no_referensi', request()->input("no_referensi"));
                }

                if(trim(request()->input("kode_produk")) != ""){
                    $query->where('kode_produk', request()->input("kode_produk"));
                }

                if(trim(request()->input("id_gudang") == "all")){
                    return $query;
                } else {
                    $query->where('id_gudang', request()->input("id_gudang"));
                }

                // if(trim(request()->input("jenis_produk") == "all")){
                //     return true;
                // } else {
                //     $query->where(DB::raw("produk.jenis"), request()->input("jenis_produk"));
                // }
            }, true)


            ->editColumn('gudang', function (KartuStok $kartuStok) {
                return $kartuStok->gudang->nama_gudang;
            })
            ->editColumn('jenis_produk', function (KartuStok $kartuStok) {
                return ($kartuStok->produk->jenis == 0) ? "Barang Mentah" : "Barang Jadi";
            })
            ->editColumn('tanggal', function (KartuStok $kartuStok) {
                return Carbon::parse($kartuStok->tanggal)->isoFormat('D MMMM Y');
            })
            ->editColumn('nama_produk', function (KartuStok $kartuStok) {
                return $kartuStok->produk->nama;
            })
            ->make(true);
    }

    public function findByLockGudangProduk($id_gudang, $kode_produk)
    {
        return KartuStok::select("*")
                        ->where("id_gudang", $id_gudang)
                        ->where("kode_produk", $kode_produk)
                        ->orderBy('tanggal', 'desc')
                        ->lockForUpdate()
                        ->first();
    }

    public function findByGudangProduk($id_gudang, $kode_produk)
    {
        return KartuStok::select("*")
                        ->where("id_gudang", $id_gudang)
                        ->where("kode_produk", $kode_produk)
                        ->orderBy('tanggal', 'desc')
                        ->first();
    }

    public function insert(array $array)
    {
        KartuStok::insert($array);
    }

}
