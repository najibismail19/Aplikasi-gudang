<?php
namespace App\Repository\Impl;

use App\Models\Pembelian;
use App\Repository\PembelianRepository;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

Class PembelianRepositoryImpl implements PembelianRepository {

    public function getDatatable(): JsonResponse
    {
        $pembelian = Pembelian::select("*")->with(["karyawan", "supplier"]);
        return DataTables::of($pembelian)
                ->addIndexColumn()

                ->filter(function ($query) {

                    if(trim(request()->input("awal")) != "" && trim(request()->input("akhir")) != ""){

                        $query->whereBetween('tanggal_pembelian', [request()->input("awal"), request()->input("akhir")]);

                    }

                }, true)

                ->editColumn('supplier', function (Pembelian $pembelian) {

                    return $pembelian->supplier->nama;

                })
              
                ->editColumn('total_produk', function (Pembelian $pembelian) {

                    return count($pembelian->detailPembelian);

                })
                ->editColumn('total_harga', function (Pembelian $pembelian) {

                    return 'Rp '.number_format($pembelian->total_keseluruhan, 0, ',', '.');

                })
                ->editColumn('tanggal', function (Pembelian $pembelian) {

                    return Carbon::parse($pembelian->tanggal_pembelian)->isoFormat('D MMMM Y');

                })
                ->addColumn('status', function (Pembelian $pembelian) {

                if($pembelian->status_penerimaan) {
                    return "<span class='badge bg-success'>Sudah Diterima</span>";
                }
                return "<span class='badge bg-danger'>Belum Diterima</span>";

                })
                ->addColumn('action', function($pembelian){

                    $btn = "";

                    if(request()->hasHeader("X-SRC-Pembelian")) {
                        $btn = $btn . "<a class='pilihPembelian btn btn-primary mx-1' id='$pembelian->no_pembelian'><i class='fas fa-check'></i></a>";
                    } else {
                        if($pembelian->status_pembelian == true) {
                            $btn = $btn . "<a class='printDetailPembelian btn btn-info mx-1' id='$pembelian->no_pembelian' href='/pembelian/detail-pembelian/print-pdf/$pembelian->no_pembelian'><i class='fas fa-print'></i></a>";
                            $btn = $btn . "<a class='btn btn-secondary mx-1' href='/pembelian/show-detail/$pembelian->no_pembelian'><i class='fas fa-eye'></i></a>";
                        }
                        if($pembelian->status_pembelian == false && $pembelian->karyawan->nik == getNik()) {
                            $btn = $btn . "<a class='btn btn-primary mx-1' href='/pembelian/$pembelian->no_pembelian'><i class='fas fa-edit'></i></a>";
                            $btn = $btn . "<a class='deletePembelian btn btn-danger mx-1' id='$pembelian->no_pembelian'><i class='fas fa-trash'></i></a>";
                        }
                    }


                    return $btn;
                })
                ->rawColumns(['action', 'status'])
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

    public function getPembelianBeforeSend()
    {
        return Pembelian::select("*")->with(["detailPembelian", "supplier"])
                            ->where("status_pembelian", true)
                            ->where("status_penerimaan", false)
                            ->get();
    }

    public function ByDateBetween($start, $end)
    {
        return Pembelian::select("*", DB::raw("DATE_FORMAT(tanggal_pembelian, '%Y-%m-%Y') as tanggal"))->with(["detailPembelian"])
                        ->where('status_pembelian', true)
                        ->whereBetween('tanggal_pembelian', [$start, $end])
                        ->get();
    }

    public function delete($no_pembelian)
    {
        Pembelian::destroy($no_pembelian);
    }
}
