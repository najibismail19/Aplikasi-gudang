<?php
namespace App\Repository\Impl;

use App\Models\DetailPenjualan;
use App\Repository\DetailPenjualanRepository;

Class DetailPenjualanRepositoryImpl implements DetailPenjualanRepository{
        public function sum($no_penjualan)
        {
            return DetailPenjualan::where("no_penjualan", $no_penjualan)->get()
            ->sum(function ($detail) {
                return (float) str_replace(',', '', $detail->total_harga);
            });
        }

        public function  ByNoPenjualanKodeProduk($no_penjualan, $kode_produk)
        {
            return DetailPenjualan::where("no_penjualan", $no_penjualan)->where("kode_produk", $kode_produk)->first();
        }

        function ByNoPenjualan($no_penjualan)
        {
            return DetailPenjualan::where("no_penjualan", $no_penjualan)->get();
        }

        public function deleteByNoPenjualanKodeProduk($no_penjualan, $kode_produk)
        {
            return DetailPenjualan::where("no_penjualan", $no_penjualan)
                                    ->where("kode_produk", $kode_produk)
                                    ->delete();
        }

        public function findByNoPenjualan($no_penjualan)
        {
           return DetailPenjualan::select("*")->with(["produk"])->where("no_penjualan", $no_penjualan);
        }
}
