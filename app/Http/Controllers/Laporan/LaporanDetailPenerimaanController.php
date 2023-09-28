<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\DetailPembelianRepository;
use App\Repository\PembelianRepository;
use App\Repository\PenerimaanRepository;
use Carbon\Carbon;
use PDF;

class LaporanDetailPenerimaanController extends Controller
{
    private PenerimaanRepository $penerimaan;

    private DetailPembelianRepository $detalPembelian;

    private PembelianRepository $pembelian;

    public function __construct(DetailPembelianRepository $detalPembelian, PenerimaanRepository $penerimaan, PembelianRepository $pembelian)
    {
        $this->penerimaan = $penerimaan;

        $this->pembelian = $pembelian;

        $this->detalPembelian = $detalPembelian;
    }

    private function getDetailPenerimaan($no_penerimaan)
    {
        $penerimaan = $this->penerimaan->findByNoPenerimaan($no_penerimaan);

        if(!$penerimaan){
            return abort(404);
        }

        $pembelian = $this->pembelian->find($penerimaan->no_pembelian)->with(["detailPembelian", "supplier", "karyawan"])->first();

        return [
            "penerimaan" => $penerimaan,
            "tanggal_penerimaan" => Carbon::parse($penerimaan->tanggal_penerimaan)->isoFormat('D MMMM Y'),
            "tanggal_pembelian" => Carbon::parse($pembelian->tanggal_pembelian)->isoFormat('D MMMM Y'),
            "detail_penerimaan" => $this->detalPembelian->findByNoPembelian($penerimaan->no_pembelian)->get(),
            "pembelian" => $pembelian
        ];
    }

    public function cetakLaporan($no_penerimaan, Request $request)
    {
        $pdf = PDF::loadview("laporan.cetak-laporan-detail-penerimaan", $this->getDetailPenerimaan($no_penerimaan));
        return $pdf->stream();
    }

    public function exportExcel($no_penerimaan, Request $request)
    {
        $data = $this->getDetailPenerimaan($no_penerimaan);

        downloadExcel([
            "A" => "No Penerimaan",
            "B" => "Tanggal Penerimaan",
            "C" => "No Pembelian",
            "D" => "Tanggal Pembelian",
            "E" => "Nama Supplier",
            "F" => "Kode Produk",
            "G" => "Nama",
            "H" => "Jenis",
            "I" => "Harga",
            "J" => "Jumlah",
            "K" => "Total Harga",
        ], function ($rows, $sheet) use ($data) {

            foreach($data["detail_penerimaan"] as $detail){
                $sheet->setCellValue('A' . $rows, $data["penerimaan"]->no_penerimaan);
                $sheet->setCellValue('B' . $rows, $data["tanggal_penerimaan"]);
                $sheet->setCellValue('C' . $rows, $data["penerimaan"]->no_pembelian);
                $sheet->setCellValue('D' . $rows, $data["tanggal_pembelian"]);
                $sheet->setCellValue('E' . $rows, $data["pembelian"]->supplier->nama);
                $sheet->setCellValue('F' . $rows, $detail->kode_produk);
                $sheet->setCellValue('G' . $rows, $detail->produk->nama);
                $sheet->setCellValue('H' . $rows, ($detail->produk->jenis == 0) ? "Barang Mentah" : "Barang Jadi");
                $sheet->setCellValue('I' . $rows, $detail->harga);
                $sheet->setCellValue('J' . $rows, $detail->jumlah);
                $sheet->setCellValue('K' . $rows, $detail->total_harga);

                $rows++;
            }

            $sheet->getStyle('J' . $rows)->getFont()->setBold(true);
            $sheet->getStyle('K' . $rows)->getFont()->setBold(true);
            $sheet->setCellValue('J' . $rows, "Total");
            $sheet->setCellValue('K' . $rows, $data["pembelian"]->total_keseluruhan);

        }, nameFile : "Data Detail Penerimaan No : " . $no_penerimaan);

    }
}
