<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\KartuStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class LaporanKartuStokController extends Controller
{

    private function getKartuStok()
    {
        $data = KartuStok::select("*", DB::raw("DATE_FORMAT(tanggal, '%d-%m-%Y') as tanggal"))->with(["produk", "gudang"])->filter(request(["awal", "akhir", "gudang", "no_referensi", "kode_produk"]))->get();

        if(count($data) < 1) {
            return abort(404);
        }

        return $data;
    }

    public function cetakLaporan()
    {

        $data = $this->getKartuStok();

        $pdf = PDF::loadview('laporan.cetak-laporan-kartu-stok', [
            "kartu_stok" => $data,
        ]);

        return $pdf->stream();
    }


    public function exportExcel()
    {
        $data = $this->getKartuStok();

        downloadExcel([
            "A" => "No Referensi",
            "B" => "Nama Gudang",
            "C" => "Tanggal",
            "D" => "Kode Produk",
            "E" => "Nama",
            "F" => "Jenis",
            "G" => "Saldo Awal",
            "H" => "Stok In",
            "I" => "Stok Out",
            "J" => "Saldo Akhir",
        ], function ($rows, $sheet) use ($data){

            foreach($data as $d){
                $sheet->setCellValue('A' . $rows, $d->no_referensi);
                $sheet->setCellValue('B' . $rows, $d->gudang->nama_gudang);
                $sheet->setCellValue('C' . $rows, $d->tanggal);
                $sheet->setCellValue('D' . $rows, $d->kode_produk);
                $sheet->setCellValue('E' . $rows, $d->produk->nama);
                $sheet->setCellValue('F' . $rows, ($d->produk->jenis == 0) ? "Barang Mentah" : "Barang Jadi");
                $sheet->setCellValue('G' . $rows, $d->saldo_awal);
                $sheet->setCellValue('H' . $rows, $d->stock_in);
                $sheet->setCellValue('I' . $rows, $d->stock_out);
                $sheet->setCellValue('J' . $rows, $d->saldo_akhir);

                $rows++;
            }
        }, nameFile : "Data Kartu Stok");
    }
}
