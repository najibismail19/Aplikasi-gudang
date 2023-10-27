<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Penerimaan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use PDF;

class LaporanPenerimaanController extends Controller
{

    function getPenerimaan()
    {
        return  Penerimaan::select("*", DB::raw("DATE_FORMAT(tanggal_penerimaan, '%d-%m-%Y') as tanggal"))->with(["karyawan", "pembelian"])
                            ->filter(request(["awal", "akhir"]))
                            ->get();
    }

    public function cetakLaporan()
    {

        $penerimaan = $this->getPenerimaan();

        if(count($penerimaan) < 1) {
            return abort(404);
        }

        $pdf = PDF::loadview('laporan.cetak-laporan-penerimaan', [
                    "penerimaan" => $penerimaan,
            ]);
        return $pdf->stream();
    }

    public function exportExcel()
    {
        $penerimaan = $this->getPenerimaan();

        if(count($penerimaan) < 1) {
            return redirect()->back();
        }

        downloadExcel([
            "A" => "No Penerimaan",
            "B" => "No Pembelian",
            "C" => "Supplier",
            "D" => "Tanggal Penerimaan",
            "E" => "Tanggal Pembelian",
            "F" => "Jumlah Jenis Produk",
            "G" => "Total Harga",
        ], function ($rows, $sheet) use ($penerimaan){
            foreach($penerimaan as $p){
                $sheet->setCellValue('A' . $rows, $p->no_penerimaan);
                $sheet->setCellValue('B' . $rows, $p->no_pembelian);
                $sheet->setCellValue('C' . $rows, $p->pembelian->supplier->nama);
                $sheet->setCellValue('D' . $rows, $p->tanggal_penerimaan);
                $sheet->setCellValue('E' . $rows, $p->pembelian->tanggal_pembelian);
                $sheet->setCellValue('F' . $rows, count($p->pembelian->detailPembelian));
                $sheet->setCellValue('G' . $rows, $p->pembelian->total_keseluruhan);

                $rows++;
            }
        }, nameFile: "Data Penerimaan");

    }
}
