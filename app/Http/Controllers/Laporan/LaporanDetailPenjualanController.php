<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Repository\DetailPenjualanRepository;
use App\Repository\PenjualanRepository;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;

class LaporanDetailPenjualanController extends Controller
{

    private PenjualanRepository $penjualan;

    private DetailPenjualanRepository $detailPenjualan;

    public function __construct(PenjualanRepository $penjualan, DetailPenjualanRepository $detailPenjualan)
    {

        $this->penjualan = $penjualan;

        $this->detailPenjualan = $detailPenjualan;

    }

    public function cetakPDF($no_penjualan)
    {
        $penjualan = $this->penjualan->getByDetailPenjualanComplete($no_penjualan);

        if(!$penjualan) return abort(404);

        $details = $this->detailPenjualan->findByNoPenjualan($penjualan->no_penjualan)->get();

        $pdf = PDF::loadview("laporan.cetak-laporan-detail-penjualan", [
            "penjualan" => $penjualan,
            "details" => $details,
            "tanggal_penjualan" => Carbon::parse($penjualan->tanggal_penjualan)->isoFormat('D MMMM Y')
        ]);

        return $pdf->stream();
    }

    public function exportExcel($no_penjualan)
    {
        $penjualan = $this->penjualan->getByDetailPenjualanComplete($no_penjualan);

        if(!$penjualan) return abort(404);

        $details = $this->detailPenjualan->findByNoPenjualan($penjualan->no_penjualan)->get();

        downloadExcel([
            "A" => "No Penjualan",
            "B" => "Kode Produk",
            "C" => "Nama Produk",
            "D" => "Jenis",
            "F" => "Jumlah",
            "G" => "Diskon",
            "H" => "Total Harga",
            "I" => "Customer"
        ], function ($rows, $sheet) use ($details, $penjualan) {

            foreach($details as $detail){
                $sheet->setCellValue('A' . $rows, $penjualan->no_penjualan);
                $sheet->setCellValue('B' . $rows, $detail->kode_produk);
                $sheet->setCellValue('C' . $rows, $detail->produk->nama);
                $sheet->setCellValue('D' . $rows, ($detail->produk->jenis == 0) ? "Barang Mentah" : "Barang Jadi");
                $sheet->setCellValue('E' . $rows, $detail->harga);
                $sheet->setCellValue('F' . $rows, $detail->jumlah);
                $sheet->setCellValue('G' . $rows, $detail->diskon);
                $sheet->setCellValue('H' . $rows, $detail->total_harga);
                $sheet->setCellValue('I' . $rows, $penjualan->customer->nama);

                $rows++;
            }

            $sheet->getStyle('F' . $rows)->getFont()->setBold(true);
            $sheet->getStyle('G' . $rows)->getFont()->setBold(true);
            $sheet->setCellValue('F' . $rows, "Total");
            $sheet->setCellValue('G' . $rows, $penjualan->total_keseluruhan);

        }, nameFile : "Data Detail Penjualan No : " . $no_penjualan);

    }
}
