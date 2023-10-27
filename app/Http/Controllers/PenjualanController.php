<?php

namespace App\Http\Controllers;

use App\Repository\CustomerRepository;
use App\Repository\DetailPenjualanRepository;
use App\Repository\PenjualanRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PenjualanController extends Controller
{

    private PenjualanRepository $penjualan;

    private DetailPenjualanRepository $detailPenjualan;

    private CustomerRepository $customer;

    public function __construct(PenjualanRepository $penjualan, CustomerRepository $customer, DetailPenjualanRepository $detailPenjualan)
    {
        $this->penjualan = $penjualan;

        $this->detailPenjualan = $detailPenjualan;

        $this->customer = $customer;
    }


    public function index()
    {

        if(request()->ajax()) {
            return $this->penjualan->getDatatable();
        }

        return response()->view("penjualan.penjualan");
    }

    public function tambahPenjualan()
    {
        return response()->view("penjualan.tambah-penjualan",[
            "no_penjualan" => generateNo(code : "PNJ", table : "penjualan")
        ]);
    }

    public function store(Request $request) : RedirectResponse
    {
            $data = $request->validate([
                "no_penjualan" => ["required", "unique:penjualan"],
                "nik" => ["required"],
                "id_customer" => ["required"],
                "tanggal_penjualan" => ["required"],
                "deskripsi" => ["max:255"]
            ]);

            $this->penjualan->insert($data);

            return redirect()->route("detail.penjualan", [ "no_penjualan" => $data["no_penjualan"]]);
    }

    public function getModalCustomer(Request $request)
    {
        if($request->ajax()) {
            $view = view('penjualan.get-modal-customer',[
                "customers" => $this->customer->getAll()
            ])->render();
            return response()->json( array('success' => true, 'modal'=> $view));
        }
    }

    public function delete(Request $request, $no_penjualan) {
        if($request->ajax()) {
            $penjualan = $this->penjualan->findByNoPenjualan($no_penjualan);

            if($penjualan->nik != getNik()){

                return response()->json([
                    "error" => "Anda Tidak Berhak Mengapus Transaksi Orang Lain"
                ]);
            }

            $details = $this->detailPenjualan->ByNoPenjualan($penjualan->no_penjualan);

            $details->each(function ($detail)  {
                $this->detailPenjualan->deleteByNoPenjualanKodeProduk($detail->no_penjualan, $detail->kode_produk);
            });

            $this->penjualan->delete($penjualan->no_penjualan);

            return response()->json([
                "success" => "Data Penjualan Berhasil Dihapus"
            ]);
        }
    }
}
