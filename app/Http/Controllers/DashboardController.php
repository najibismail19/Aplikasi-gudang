<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Pembelian;
use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return response()->view("dashboard.dashboard",[
            "users" => Karyawan::count(),
            "suppliers" => Supplier::count(),
            "products" => Produk::count(),
        ]);
    }

    public function getChartStok(Request $request, $filter_stok)
    {
        if($request->ajax()) {

            $date = \Carbon\Carbon::parse($filter_stok."-01"); // universal truth month's first day is 1
            $start = $date->startOfMonth()->format('Y-m-d H:i:s'); // 2000-02-01 00:00:00
            $end = $date->endOfMonth()->format('Y-m-d H:i:s');

            $purchases = Pembelian::select("*", DB::raw("DATE_FORMAT(tanggal_pembelian, '%Y-%m-%Y') as tanggal"))
            ->where("status_penerimaan", true)
            ->whereBetween('tanggal_pembelian', [$start, $end])
            ->get();

            $total = [];
            $tanggal = [];
            foreach( $purchases as $purchase) {
                $total[] = $purchase->total_keseluruhan;
                $tanggal[] = $purchase->tanggal;
            }
            $view = view('dashboard.get-chart-stok', [
                "tanggal" => $tanggal,
                "total" => $total
            ])->render();
            return response()->json( array('success' => true, 'chart_stok'=> $view));
        }

    }
}
