<?php
namespace App\Repository\Impl;

use App\Repository\PenerimaanRepository;
use Illuminate\Http\JsonResponse;
use App\Models\Penerimaan;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

Class PenerimaanRepositoryImpl implements PenerimaanRepository {

    public function getDatatable($data): JsonResponse
    {
        return DataTables::of($data)
                            ->addIndexColumn()
                            ->editColumn('karyawan', function (Penerimaan $penerimaan) {
                                return $penerimaan->karyawan->nama;
                            })
                            ->editColumn('tanggal', function (Penerimaan $penerimaan) {
                                return Carbon::parse($penerimaan->tanggal_penerimaan)->isoFormat('dddd, D MMMM Y');
                            })
                            ->addColumn('action', function($penerimaan){
                                $btn ="<a class='editpembelian btn btn-primary mx-1'><i class='align-middle' data-feather='edit'></i></a>";
                                $btn = $btn."<a id='$penerimaan->no_penerimaan' class='hapuspembelian btn btn-danger'><i class='align-middle' data-feather='trash'></i></a>";
                                return $btn;
                            })
                            ->rawColumns(['action'])
                            ->make(true);
    }

    public function all()
    {
        return Penerimaan::select("*")->with(["karyawan", "pembelian"]);
    }

    public function insert(array $array)
    {
        Penerimaan::insert($array);
    }

}
