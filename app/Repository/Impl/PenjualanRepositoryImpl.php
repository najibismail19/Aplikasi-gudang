<?php
namespace App\Repository\Impl;

use App\Models\Penjualan;
use App\Repository\PenjualanRepository;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

Class PenjualanRepositoryImpl implements PenjualanRepository{

    public function getDatatable(): JsonResponse
    {

        $penjualan = Penjualan::select("*")->with(["karyawan", "customer"]);

        return DataTables::of($penjualan)
        ->addIndexColumn()
        ->filter(function ($query) {

            if(trim(request()->input("awal")) != "" && trim(request()->input("akhir")) != ""){

                $query->whereBetween('tanggal_penjualan', [request()->input("awal"), request()->input("akhir")]);

            }

        }, true)
        ->editColumn('customer', function (Penjualan $penjualan) {

            return $penjualan->customer->nama;

        })
        ->editColumn('karyawan', function (Penjualan $penjualan) {

            return $penjualan->karyawan->nama;

        })
        ->editColumn('total_harga', function (Penjualan $penjualan) {

            return 'Rp '.number_format($penjualan->total_keseluruhan, 0, ',', '.');

        })
        ->editColumn('total_produk', function (Penjualan $penjualan) {

            return count($penjualan->detailPenjualan);

        })
        ->editColumn('tanggal', function (Penjualan $penjualan) {

            return Carbon::parse($penjualan->tanggal_penjualan)->isoFormat('D MMMM Y');

        })
        ->addColumn('action', function($penjualan){

            $btn = "";


            if($penjualan->status_penjualan == true) {
                $btn = $btn . "<a class='btn btn-secondary mx-1' href='/penjualan/show-detail/$penjualan->no_penjualan'><i class='align-middle' data-feather='eye'></i></a>";
                $btn = $btn . "<a class='printDetailPembelian btn btn-info mx-1' href='/penjualan/print/detail-penjualan/print-pdf/$penjualan->no_penjualan' id='$penjualan->no_pembelian'><i class='align-middle' data-feather='printer'></i></a>";
            }
            if($penjualan->status_penjualan == false) {
                if($penjualan->karyawan->nik == getNik()) {
                    $btn = $btn . "<a class='btn btn-primary mx-1' href='/penjualan/$penjualan->no_penjualan'><i class='align-middle' data-feather='edit'></i></a>";
                    $btn = $btn . "<a class='hapusPenjualan btn btn-danger mx-1' id='$penjualan->no_penjualan'><i class='align-middle' data-feather='trash'></i></a>";
                } else {
                    $btn = $btn . "<span class='badge bg-danger'>Sedang Process</span>";
                }
            }

            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function insert($data)
    {
        Penjualan::insert($data);
    }

    public function findByNoPenjualan($no_penjualan)
    {
        return Penjualan::select("*")->with(["detailPenjualan"])->where("no_penjualan", $no_penjualan)->first();
    }

    public function find($no_penjualan)
    {
        $penjualan = Penjualan::find($no_penjualan);
        if($penjualan) {
            return $penjualan;
        }
        return null;
    }

    public function insertPivotDetailPejualan($no_penjualan, $kode_produk, array $content)
    {
        $penjualan = $this->find($no_penjualan);

        $penjualan->detailPenjualan()->attach($kode_produk, $content);
    }

    public function update($no_penjualan, array $content) {

        $penjulana = $this->find($no_penjualan);

        $penjulana->fill($content);

        $penjulana->update();
    }

    public function updatePivotDetailPenjualan($no_penjualan, $kode_produk, array $content)
    {
        $penjualan = $this->find($no_penjualan);

        $penjualan->detailPenjualan()->updateExistingPivot($kode_produk, $content);
    }

    public function ByDateBetween($start, $end)
    {
        return Penjualan::select("*", DB::raw("DATE_FORMAT(tanggal_penjualan, '%Y-%m-%Y') as tanggal"))
                    ->where("status_penjualan", true)
                    ->whereBetween('tanggal_penjualan', [$start, $end])
                    ->get();
    }

    public function BygetMostPopularProducts($start, $end, $row)
    {
         return  Penjualan::query()->whereBetween('tanggal_penjualan', [$start, $end])->where("status_penjualan", true)
                            ->join('detail_penjualan', 'detail_penjualan.no_penjualan', '=', 'penjualan.no_penjualan')
                            ->join('produk', 'detail_penjualan.kode_produk', '=', 'produk.kode_produk')
                            ->select('produk.kode_produk', DB::raw('SUM(detail_penjualan.jumlah) as total_sold'))
                            ->groupBy('produk.kode_produk')
                            ->orderBy('total_sold', 'desc')
                            ->take($row)
                            ->get();
    }

    public function getByDetailPenjualanComplete($no_penjualan)
    {
        return  Penjualan::select("*")->with(["detailPenjualan", "customer"])
                            ->where("no_penjualan", $no_penjualan)
                            ->where("status_penjualan", true)
                            ->first();
    }

    public function delete($no_penjualan)
    {
        Penjualan::destroy($no_penjualan);
    }
}
