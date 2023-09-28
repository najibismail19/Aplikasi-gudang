<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class LaporanPembelianController extends Controller
{

    private function getPembelian()
    {
        return Pembelian::select("*", DB::raw("DATE_FORMAT(tanggal_pembelian, '%d-%m-%Y') as tanggal"))->latest("tanggal_pembelian")
                            ->where("status_pembelian", true)
                            ->where(function(Builder $builder) {
                                if(trim(request()->input("awal")) != "" && trim(request()->input("akhir")) != "") {
                                    $builder->whereBetween('tanggal_pembelian', [request()->input("awal"), request()->input("akhir")]);
                                }
                            })
                            ->get();
    }

    public function cetakLaporan(Request $request)
    {
        $pembelian = $this->getPembelian();

        if (count($pembelian) < 1) return abort(404);

        $pdf = PDF::loadview('laporan.cetak-laporan-pembelian', [
            "pembelian" => $pembelian,
        ]);

        return $pdf->stream();
    }

    public function exportExcel()
    {
        $pembelian = $this->getPembelian();

        if(count($pembelian) < 1) return response()->back();

        downloadExcel([
            "A" => "No Pembelian",
            "B" => "Nama Supplier",
            "C" => "Tanggal Pembelian",
            "D" => "Jumlah Jenis Produk",
            "E" => "Total Harga"
        ], function ($rows, $sheet) use ($pembelian){

            foreach($pembelian as $p){
                $sheet->setCellValue('A' . $rows, $p->no_pembelian);
                $sheet->setCellValue('B' . $rows, $p->supplier->nama);
                $sheet->setCellValue('C' . $rows, $p->tanggal_pembelian);
                $sheet->setCellValue('D' . $rows, count($p->detailPembelian));
                $sheet->setCellValue('E' . $rows, $p->total_keseluruhan);

                $rows++;
            }
        }, nameFile : "Data Pembelian");
    }
}
