<?php
namespace App\Repository\Impl;

use App\Models\Prakitan;
use App\Repository\PrakitanRepository;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

Class PrakitanRepositoryImpl implements PrakitanRepository{


    public function getDatatable() : JsonResponse
    {
        $data = Prakitan::select("*")->with(["produk", "karyawan"]);
        return DataTables::of($data)
            ->addIndexColumn()

            ->filter(function ($query) {
                // if(request()-> == "all") return true;
                if(trim(request()->input("awal")) != "" && trim(request()->input("akhir")) != ""){
                    $query->whereBetween('tanggal_actual_prakitan', [request()->input("awal"), request()->input("akhir")]);
                }

            }, true)

            ->editColumn('karyawan', function (Prakitan $prakitan) {
                return $prakitan->karyawan->nama;
            })
            ->editColumn('jenis_produk', function (Prakitan $prakitan) {
                return ($prakitan->produk->jenis == 0) ? "Barang Mentah" : "Barang Jadi";
            })
            ->editColumn('qty_hasil', function (Prakitan $prakitan) {
                return ($prakitan->qty_hasil == null) ? "Sedang Prakitan" : $prakitan->qty_hasil;
            })
            ->editColumn('tanggal_rencana', function (Prakitan $prakitan) {
                return Carbon::parse($prakitan->tanggal_rencana)->isoFormat('D MMMM Y');
            })
            ->editColumn('tanggal_actual_prakitan', function (Prakitan $prakitan) {
                if($prakitan->tanggal_actual_prakitan != null) {
                    return Carbon::parse($prakitan->tanggal_actual_prakitan)->isoFormat('D MMMM Y');
                }
                return "Sedang Prakitan";
            })
            ->editColumn('nama_produk', function (Prakitan $prakitan) {
                return $prakitan->produk->nama;
            })
            ->addColumn('action', function($prakitan){
                $btn = "";


                if($prakitan->tanggal_actual_prakitan == null && $prakitan->qty_hasil == null) {
                    if($prakitan->nik == getNik()) {
                        $btn = $btn . "<a href='/prakitan/$prakitan->no_prakitan' class='btn btn-primary'><i class='align-middle' data-feather='edit'></i></a>";
                    }
                } else {
                    $btn = $btn . "<a href='/prakitan/detail-prakitan/print-pdf/$prakitan->no_prakitan' class='btn btn-info'><i class='align-middle' data-feather='printer'></i></a>";
                    $btn = $btn . "<a href='/prakitan/show-detail/$prakitan->no_prakitan' class='btn btn-secondary mx-1'><i class='align-middle' data-feather='eye'></i></a>";
                }

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function find($no_prakitan)
    {
        $prakitan = Prakitan::find($no_prakitan);
        if($prakitan) {
            return $prakitan;
        }
        return null;
    }

    public function insert(array $data)
    {
        Prakitan::insert($data);
    }

    public function insertPivotDetailPrakitan($no_prakitan, $kode_produk, array $content)
    {
        $pembelian = $this->find($no_prakitan);

        $pembelian->detailPrakitan()->attach($kode_produk, $content);
    }

    public function updatePivotDetailPrakitan($no_prakitan, $kode_produk, array $content)
    {
        $pembelian = $this->find($no_prakitan);

        $pembelian->detailPrakitan()->updateExistingPivot($kode_produk, $content);
    }

    public function update($no_prakitan, array $data)
    {
        $prakitan = $this->find($no_prakitan);

        $prakitan->fill($data);

        $prakitan->update();
    }

}
