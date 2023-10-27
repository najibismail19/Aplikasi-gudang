<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Karyawan;
use App\Models\Produk;
use App\Models\Gudang;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Repository\PembelianRepository;
use App\Repository\PenjualanRepository;
use App\Repository\StokRepository;

class DashboardController extends Controller
{

    private PembelianRepository $pembelian;

    private PenjualanRepository $penjualan;

    private StokRepository $stok;

    public function __construct(PembelianRepository $pembelian, PenjualanRepository $penjualan, StokRepository $stok) {

        $this->penjualan = $penjualan;

        $this->pembelian = $pembelian;

        $this->stok = $stok;
    }

    public function getDataTransaction($grafik) {

        $sumbu_y = [];

        $sumbu_x = [];

        if($grafik == "pembelian" || $grafik == "penjualan" || $grafik == "produk_terlaris") {
            $date = \Carbon\Carbon::parse(request()->input("bulan") ."-01"); // universal truth month's first day is 1
            $start = $date->startOfMonth()->format('Y-m-d H:i:s'); // 2000-02-01 00:00:00
            $end = $date->endOfMonth()->format('Y-m-d H:i:s');

            if($grafik == "pembelian") {
                $data = $this->pembelian->ByDateBetween($start, $end);
            }

            if($grafik == "penjualan") {
                $data = $this->penjualan->ByDateBetween($start, $end);
            }
        }

        if($grafik == "stok") {
            $data = $this->stok->ByDescStok(request()->input("gudang"), request()->input("limit"));
        }

        if($grafik == "produk_terlaris") {
            $data = $this->penjualan->BygetMostPopularProducts($start, $end, request()->input("limit"));
        }



        if(count($data) > 0) {
            foreach( $data as $d) {
                if($grafik == "stok") {

                    $sumbu_y[] = $d->stok;
                    $sumbu_x[] = $d->produk->nama;

                } else if ($grafik == "produk_terlaris") {

                    $sumbu_y[] = $d->total_sold;
                    $sumbu_x[] = Produk::find($d->kode_produk)->nama;

                } else {

                    $sumbu_y[] = $d->total_keseluruhan;
                    $sumbu_x[] = $d->tanggal;

                }

                $red = rand(0, 255);
                $green = rand(0, 255);
                $blue = rand(0, 255);
                $alpha = mt_rand(1, 9) / 10; // Menghasilkan alpha dari 0.1 hingga 0.9

                $rgb[] = "rgba($red, $green, $blue, $alpha)";
            }

            return [
                "sumbu_y" => $sumbu_y,
                "sumbu_x" => $sumbu_x,
                "rgb" => $rgb
            ];
        }

        return [
            "sumbu_y" => [],
            "sumbu_x" => [],
            "rgb" => []
        ];
    }

    public function index()
    {
        return response()->view("dashboard.dashboard",[
            "users" => Karyawan::count(),
            "suppliers" => Supplier::count(),
            "products" => Produk::count(),
            "gudang" => Gudang::all(),
            "customers" => Customer::count()
        ]);
    }

    public function getChartPenjualan(Request $request) {
        if($request->ajax()) {

             $view = view('dashboard.get-chart-penjualan', $this->getDataTransaction("penjualan"))->render();

             return response()->json( array('success' => true, 'chart_penjualan'=> $view));
        }
    }

    public function getChartPembelian(Request $request)
    {
        if($request->ajax()) {

            $view = view('dashboard.get-chart-pembelian', $this->getDataTransaction("pembelian"))->render();

            return response()->json( array('success' => true, 'chart_pembelian'=> $view));
        }
    }
    public function getChartProdukTerbanyak(Request $request)
    {
        if($request->ajax()) {

            $view = view('dashboard.get-chart-produk-terbanyak',$this->getDataTransaction("stok") )->render();

            return response()->json( array('success' => true, 'chart_produk_terbanyak'=> $view));

        }
    }

    public function getChartProdukTerlaris(Request $request)
    {
        if($request->ajax()) {

            $view = view('dashboard.get-chart-produk_terlaris', $this->getDataTransaction("produk_terlaris"))->render();

            return response()->json( array('success' => true, 'chart_produk_terlaris'=> $view));

        }
    }
}
