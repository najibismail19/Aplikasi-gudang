<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Prakitan;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class LaporanPrakitanController extends Controller
{

    private function getPrakitan() : Collection
    {
        $data =  Prakitan::select("*", DB::raw("DATE_FORMAT(tanggal_rencana, '%d-%m-%Y') as tgl_rencana"),  DB::raw("DATE_FORMAT(tanggal_actual_prakitan, '%d-%m-%Y') as tgl_actual"))->with(["produk", "karyawan"])->filter(request(["awal", "akhir"]))->whereNotNull("tanggal_actual_prakitan")->get();

        if(count($data) < 1) return abort(404);

        return $data;
    }
    public function cetakLaporan()
    {

        $data = $this->getPrakitan();

        $pdf = PDF::loadview('laporan.cetak-laporan-prakitan', [
            "prakitan" => $data,
        ]);

        return $pdf->stream();
    }

    public function exportExcel()
    {

        $data = $this->getPrakitan();

        downloadExcel([
            "A" => "No Prakitan",
            "B" => "Kode Produk",
            "C" => "Nama",
            "D" => "Tanggal Rencana",
            "E" => "Qty Rencana",
            "F" => "Tanggal Aktual",
            "G" => "Qty Hasil"
        ], function ($rows, $sheet) use ($data){

            foreach($data as $d){
                $sheet->setCellValue('A' . $rows, $d->no_prakitan);
                $sheet->setCellValue('B' . $rows, $d->kode_produk);
                $sheet->setCellValue('C' . $rows, $d->produk->nama);
                $sheet->setCellValue('D' . $rows, $d->tgl_rencana);
                $sheet->setCellValue('E' . $rows, $d->qty_rencana);
                $sheet->setCellValue('F' . $rows, $d->tgl_actual);
                $sheet->setCellValue('G' . $rows, $d->qty_hasil);

                $rows++;
            }
        }, nameFile : "Data Prakitan");
    }
}
