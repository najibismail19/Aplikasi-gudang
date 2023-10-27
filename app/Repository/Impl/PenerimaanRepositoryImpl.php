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

                            ->filter(function ($query) {
                                // if(request()-> == "all") return true;
                                if(trim(request()->input("awal")) != "" && trim(request()->input("akhir")) != ""){
                                    $query->whereBetween('tanggal_penerimaan', [request()->input("awal"), request()->input("akhir")]);
                                } else {
                                    return true;
                                }
                            }, true)
                            ->editColumn('supplier', function (Penerimaan $penerimaan) {
                                return $penerimaan->pembelian->supplier->nama;
                            })
                            ->editColumn('total_produk', function (Penerimaan $penerimaan) {
                                return count($penerimaan->pembelian->detailPembelian);
                            })
                            ->editColumn('karyawan', function (Penerimaan $penerimaan) {
                                return $penerimaan->karyawan->nama;
                            })
                            ->editColumn('tanggal', function (Penerimaan $penerimaan) {
                                return Carbon::parse($penerimaan->tanggal_penerimaan)->isoFormat('D MMMM Y');
                            })
                            ->addColumn('action', function($penerimaan){
                                $btn = "<a class='btn btn-info'><i class='align-middle' data-feather='printer'></i></a>";
                                $btn = $btn . "<a class='btn btn-secondary mx-1' href='/penerimaan/show-detail/$penerimaan->no_penerimaan'><i class='align-middle' data-feather='eye'></i></a>";
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

    public function findByNoPenerimaan($no_penerimaan)
    {
        $penerimaan =  Penerimaan::find($no_penerimaan);
        if(!$penerimaan) {
            return null;
        }
        return $penerimaan->with(["pembelian"])->first();
    }

}
