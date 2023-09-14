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

                    return Carbon::parse($pembelian->tanggal_pembelian)->isoFormat('dddd, D MMMM Y');

                })
                ->addColumn('action', function($pembelian){

                    $btn = "";
                    $icon = "check";

                    if(!request()->hasHeader("X-SRC-Pembelian")) {

                        $btn = $btn. "<a id='$pembelian->no_pembelian' class='hapuspembelian btn btn-danger'><i class='align-middle' data-feather='trash'></i></a>";
                        $icon = "edit";

                    }

                    $actionClick = ($icon == 'edit') ? 'editPembelian' : 'pilihPembelian';
                    $btn = $btn . "<a class='$actionClick btn btn-primary mx-1' id='$pembelian->no_pembelian'><i class='align-middle' data-feather='$icon'></i></a>";

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
}
