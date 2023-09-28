<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Repository\DetailPembelianRepository;
use App\Repository\PembelianRepository;
use Carbon\Carbon;
use PDF;

class LaporanDetailPembelianController extends Controller
{

    private PembelianRepository $pembelian;

    private DetailPembelianRepository $detailPembelian;

    public function __construct(PembelianRepository $pembelian, DetailPembelianRepository $detailPembelian)
    {
        $this->pembelian = $pembelian;

        $this->detailPembelian = $detailPembelian;
    }

    public function cetakPDF($no_pembelian)
    {
        $pembelian = $this->pembelian->getByDetailPembelianComplete($no_pembelian);

        if(!$pembelian) return abort(404);

        $details = $this->detailPembelian->findByNoPembelian($pembelian->no_pembelian)->get();

        $pdf = PDF::loadview("laporan.cetak-laporan-detail-pembelian", [
            "pembelian" => $pembelian,
            "details" => $details,
            "tanggal_pembelian" => Carbon::parse($pembelian->tanggal_pembelian)->isoFormat('D MMMM Y')
        ]);

        return $pdf->stream();
    }

    public function exportExcel($no_pembelian)
    {
        $pembelian = $this->pembelian->getByDetailPembelianComplete($no_pembelian);

        if(!$pembelian) return abort(404);

        $details = $this->detailPembelian->findByNoPembelian($pembelian->no_pembelian)->get();

        downloadExcel([
            "A" => "No Pembelian",
            "B" => "Kode Produk",
            "C" => "Nama Produk",
            "D" => "Jenis",
            "F" => "Jumlah",
            "G" => "Total Harga",
            "H" => "Supplier"
        ], function ($rows, $sheet) use ($details, $pembelian) {

            foreach($details as $detail){
                $sheet->setCellValue('A' . $rows, $pembelian->no_pembelian);
                $sheet->setCellValue('B' . $rows, $detail->kode_produk);
                $sheet->setCellValue('C' . $rows, $detail->produk->nama);
                $sheet->setCellValue('D' . $rows, ($detail->produk->jenis == 0) ? "Barang Mentah" : "Barang Jadi");
                $sheet->setCellValue('E' . $rows, $detail->harga);
                $sheet->setCellValue('F' . $rows, $detail->jumlah);
                $sheet->setCellValue('G' . $rows, $detail->total_harga);
                $sheet->setCellValue('H' . $rows, $pembelian->supplier->nama);

                $rows++;
            }

            $sheet->getStyle('F' . $rows)->getFont()->setBold(true);
            $sheet->getStyle('G' . $rows)->getFont()->setBold(true);
            $sheet->setCellValue('F' . $rows, "Total");
            $sheet->setCellValue('G' . $rows, $pembelian->total_keseluruhan);

        }, nameFile : "Data Detail Pembelian No : " . $no_pembelian);

    }

}
