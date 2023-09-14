<?php
namespace App\Repository\Impl;

use App\Models\DetailPembelian;
use App\Repository\DetailPembelianRepository;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;

Class DetailPembelianRepositoryImpl implements DetailPembelianRepository {

    public function getDatatable($data): JsonResponse
    {
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('nama_produk', function (DetailPembelian $detailPembelian) {
                return $detailPembelian->produk->nama;
            })
            ->addColumn('action', function($detailPembelian){
                $btn ="<a class='editDetailPembelian btn btn-primary mx-1'
                data-kode_produk='{$detailPembelian->kode_produk}'
                data-nama_produk='{$detailPembelian->produk->nama}'
                data-harga='{$detailPembelian->harga}'
                data-jenis='{$detailPembelian->produk->jenis}'
                data-gambar='{$detailPembelian->produk->gambar}'
                data-jumlah='{$detailPembelian->jumlah}'
                data-total_harga='{$detailPembelian->total_harga}'
                ><i class='align-middle' data-feather='edit'></i></a>";
                $btn = $btn."<a data-no_pembelian='$detailPembelian->no_pembelian' data-kode_produk='$detailPembelian->kode_produk' class='hapusDetailPembelian btn btn-danger'><i class='align-middle' data-feather='trash'></i></a>";
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function findByNoPembelian($no_pembelian)
    {
       return DetailPembelian::select("*")->with(["produk"])->where("no_pembelian", $no_pembelian);
    }

    public function allByNoPembelian($no_pembelian)
    {
       return DetailPembelian::select("*")->with(["produk"])->where("no_pembelian", $no_pembelian)->get();
    }

    public function findByNoPembelianKodeProduk($no_pembelian, $kode_produk)
    {
        return DetailPembelian::where("no_pembelian", $no_pembelian)
                                ->where("kode_produk", $kode_produk)
                                ->first();
    }


    public function deleteByNoPembelianKodeProduk($no_pembelian, $kode_produk)
    {
        return DetailPembelian::where("no_pembelian", $no_pembelian)
                                ->where("kode_produk", $kode_produk)
                                ->delete();
    }

    public function sum($no_pembelian)
    {
        return DetailPembelian::where("no_pembelian", $no_pembelian)->get()
        ->sum(function ($detail) {
            return (float) str_replace(',', '', $detail->total_harga);
        });
    }
}
