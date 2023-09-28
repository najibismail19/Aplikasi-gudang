<?php
namespace App\Repository\Impl;

use App\Models\Pembelian;
use App\Repository\PembelianRepository;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

Class PembelianRepositoryImpl implements PembelianRepository {

    public function getDatatable(): JsonResponse
    {
        $filter["status_pembelian"] = false;
        if(request()->hasHeader("X-SRC-Pembelian"))
        {
            $filter["status_pembelian"] = true;
        }
        $pembelian = Pembelian::select("*")->filter(filter : $filter)->with(["karyawan", "supplier"]);
        return DataTables::of($pembelian)
                ->addIndexColumn()

                ->filter(function ($query) {
                    // if(request()-> == "all") return true;
                    if(trim(request()->input("awal")) != "" && trim(request()->input("akhir")) != ""){
                        $query->whereBetween('tanggal_pembelian', [request()->input("awal"), request()->input("akhir")]);
                    } else {
                        return true;
                    }
                }, true)

                ->editColumn('supplier', function (Pembelian $pembelian) {

                    return $pembelian->supplier->nama;

                })
                ->editColumn('karyawan', function (Pembelian $pembelian) {

                    return $pembelian->karyawan->nama;

                })
                ->editColumn('total_produk', function (Pembelian $pembelian) {

                    return count($pembelian->detailPembelian);

                })
                ->editColumn('tanggal', function (Pembelian $pembelian) {

                    return Carbon::parse($pembelian->tanggal_pembelian)->isoFormat('D MMMM Y');

                })
                ->addColumn('action', function($pembelian){

                    $btn = "";

                    if(request()->hasHeader("X-SRC-Pembelian")) {
                        $btn = $btn . "<a class='pilihPembelian btn btn-primary mx-1' id='$pembelian->no_pembelian'><i class='align-middle' data-feather='check'></i></a>";
                    } else {
                        if($pembelian->status_pembelian == false && $pembelian->karyawan->nik == getNik()) {
                            $btn = $btn . "<a class='btn btn-primary mx-1' href='/pembelian/$pembelian->no_pembelian'><i class='align-middle' data-feather='edit'></i></a>";
                        } else {
                            $btn = $btn . "<a class='btn btn-secondary mx-1' href='/pembelian/show-detail/$pembelian->no_pembelian'><i class='align-middle' data-feather='eye'></i></a>";
                            $btn = $btn . "<a class='printDetailPembelian btn btn-info mx-1' id='$pembelian->no_pembelian'><i class='align-middle' data-feather='printer'></i></a>";
                        }
                    }


                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function find($no_pembelian)
    {
        $pembelian = Pembelian::find($no_pembelian);
        if($pembelian) {
            return $pembelian;
        }
        return null;
    }

    public function insert($data)
    {
        Pembelian::insert($data);
    }

    public function insertPivotDetailPembelian($no_pembelian, $kode_produk, array $content)
    {
        $pembelian = $this->find($no_pembelian);

        $pembelian->detailPembelian()->attach($kode_produk, $content);
    }

    public function updatePivotDetailPembelian($no_pembelian, $kode_produk, array $content)
    {
        $pembelian = $this->find($no_pembelian);

        $pembelian->detailPembelian()->updateExistingPivot($kode_produk, $content);
    }

    public function deletePivotDetailPembelian($no_pembelian, $kode_produk)
    {
        $pembelian = $this->find($no_pembelian);

        $pembelian->detailPembelian()->detach($kode_produk);
    }

    public function update($no_pembelian, array $content) {

        $pembelian = $this->find($no_pembelian);

        $pembelian->fill($content);

        $pembelian->update();
    }


    public function getByDetailPembelianComplete($no_pembelian)
    {
        return Pembelian::select("*")->with(["detailPembelian", "supplier"])
                            ->where("no_pembelian", $no_pembelian)
                            ->where("status_pembelian", true)
                            ->first();
    }
}
