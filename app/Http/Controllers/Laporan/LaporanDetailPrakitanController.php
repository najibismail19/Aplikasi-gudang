<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Repository\MasterPrakitanRepository;
use App\Repository\PrakitanRepository;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;

class LaporanDetailPrakitanController extends Controller
{

    private PrakitanRepository $prakitan;

    private MasterPrakitanRepository $masterPrakitan;



    public function __construct(PrakitanRepository $prakitan, MasterPrakitanRepository $masterPrakitan) {

        $this->prakitan = $prakitan;

        $this->masterPrakitan = $masterPrakitan;
    }

    private function getDetailPrakitan($no_prakitan) : array
    {
        $prakitan = $this->prakitan->find($no_prakitan);
        if(!$prakitan){
            return abort(404);
        }
        $detail_prakitan = $this->masterPrakitan->getDetailMasterIsActive($prakitan->kode_produk);

        return [
            "detail_prakitan" => $detail_prakitan,
            "prakitan" => $prakitan,
            "tanggal_rencana" => Carbon::parse($prakitan->tanggal_rencana)->isoFormat('D MMMM Y'),
            "tanggal_actual" => Carbon::parse($prakitan->tanggal_actual_prakitan)->isoFormat('D MMMM Y'),
        ];
    }


    public function cetakLaporan($no_prakitan, Request $request)
    {
        $pdf = PDF::loadview('laporan.cetak-laporan-detail-prakitan', $this->getDetailPrakitan($no_prakitan));
        return $pdf->stream();
    }

    public function exportExcel($no_prakitan, Request $request)
    {
        $data = $this->getDetailPrakitan($no_prakitan);

        downloadExcel([
            "A" => "No Prakitan",
            "B" => "Kode Produk Jadi",
            "C" => "Nama Produk Jadi",
            "D" => "Tanggal Rencana",
            "E" => "Qty Rencana",
            "F" => "Tanggal Aktual",
            "G" => "Quantity Hasil",
            "H" => "Kode Produk Mentah",
            "I" => "Nama Produk Mentah ",
            "J" => "Diambil",
            "K" => "Digunakan",
            "L" => "Dikembalikan",
        ], function ($rows, $sheet) use ($data) {

            foreach($data["detail_prakitan"] as $detail){
                $sheet->setCellValue('A' . $rows, $data["prakitan"]->no_prakitan);
                $sheet->setCellValue('B' . $rows, $data["prakitan"]->kode_produk);
                $sheet->setCellValue('C' . $rows, $data["prakitan"]->produk->nama);
                $sheet->setCellValue('D' . $rows, $data["tanggal_rencana"]);
                $sheet->setCellValue('E' . $rows, $data["prakitan"]->qty_rencana);
                $sheet->setCellValue('F' . $rows, $data["tanggal_actual"]);
                $sheet->setCellValue('G' . $rows, $data["prakitan"]->qty_hasil);
                $sheet->setCellValue('H' . $rows, $detail->kode_produk_mentah);
                $sheet->setCellValue('I' . $rows, $detail->produk_mentah->nama);
                $sheet->setCellValue('J' . $rows, $detail->quantity * $data["prakitan"]->qty_rencana);
                $sheet->setCellValue('K' . $rows, $detail->quantity * $data["prakitan"]->qty_hasil);
                $sheet->setCellValue('L' . $rows, ($detail->quantity * $data["prakitan"]->qty_rencana) -($detail->quantity * $data["prakitan"]->qty_hasil));

                $rows++;
            }
        }, nameFile : "Data Detail Prakitan No : " . $no_prakitan);
    }
}
