<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use PDF;

class LaporanPenjualanController extends Controller
{
    private function getPejualan()
    {
        return Penjualan::select("*", DB::raw("DATE_FORMAT(tanggal_penjualan, '%d-%m-%Y') as tanggal"))->latest("tanggal_penjualan")
                            ->where("status_penjualan", true)
                            ->where(function(Builder $builder) {
                                if(trim(request()->input("awal")) != "" && trim(request()->input("akhir")) != "") {
                                    $builder->whereBetween('tanggal_penjualan', [request()->input("awal"), request()->input("akhir")]);
                                }
                            })
                            ->get();
    }

    public function cetakPDF(Request $request)
    {
        $penjualan = $this->getPejualan();

        if (count($penjualan) < 1) return abort(404);

        $pdf = PDF::loadview('laporan.cetak-laporan-penjualan', [
            "penjualan" => $penjualan,
        ]);

        return $pdf->stream();
    }

    public function exportExcel()
    {
        $penjualan = $this->getPejualan();

        if(count($penjualan) < 1) return abort(404);

        downloadExcel([
            "A" => "No Penjualan",
            "B" => "Nama Customer",
            "C" => "Tanggal Penjualan",
            "D" => "Jumlah Jenis Produk",
            "E" => "Total Harga"
        ], function ($rows, $sheet) use ($penjualan){

            foreach($penjualan as $p){
                $sheet->setCellValue('A' . $rows, $p->no_penjualan);
                $sheet->setCellValue('B' . $rows, $p->customer->nama);
                $sheet->setCellValue('C' . $rows, $p->tanggal_penjualan);
                $sheet->setCellValue('D' . $rows, count($p->detailPenjualan));
                $sheet->setCellValue('E' . $rows, $p->total_keseluruhan);

                $rows++;
            }
        }, nameFile : "Data Penjualan");
    }
}
