<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Repository\DetailPembelianRepository;
use App\Repository\PembelianRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class PembelianController extends Controller
{
    private PembelianRepository $pembelian;

    private DetailPembelianRepository $detailPembelian;

    public function __construct(PembelianRepository $pembelian, DetailPembelianRepository $detailPembelian) {

        // if (Gate::allows('pembelian')) {
        //     abort(404);
        // }

        $this->pembelian = $pembelian;

        $this->detailPembelian = $detailPembelian;
    }

    public function index(Request $request) : Response | JsonResponse
    {
        if ($request->ajax()) {
            return $this->pembelian->getDatatable();
        }

        return response()->view("pembelian.pembelian");
    }

    public function tambahPembelian(Request $request) : Response
    {
        return response()->view("pembelian.pembelian-tambah", [
            "no_pembelian" => generateNo(code : "PGD", table : "pembelian"),
            "karyawan" => Auth::guard("karyawan")->user()
        ]);
    }

    public function getModalSupplier(Request $request) : JsonResponse
    {
        if($request->ajax()) {
            $view = view('pembelian.get-modal-supplier',[
                "suppliers" => Supplier::all()
            ])->render();
            return response()->json( array('success' => true, 'modal'=> $view));
        }
    }

    public function store(Request $request) : RedirectResponse
    {
            $pembelian = $request->validate([
                "no_pembelian" => ["required", "unique:pembelian"],
                "nik" => ["required"],
                "id_supplier" => ["required"],
                "tanggal_pembelian" => ["required"],
                "deskripsi" => ["max:255"]
            ]);

            $this->pembelian->insert($pembelian);

            return redirect()->route("detail.pembelian", [ "no_pembelian" => $pembelian["no_pembelian"]]);
        }



        public function delete(Request $request, $no_pembelian) {
            if($request->ajax()) {
                $pembelian = $this->pembelian->find($no_pembelian);

                if($pembelian->nik != getNik()){

                    return response()->json([
                        "error" => "Anda Tidak Berhak Mengapus Transaksi Orang Lain"
                    ]);
                }

                $details = $this->detailPembelian->findByNoPembelian($pembelian->no_pembelian)->get();

                $details->each(function ($detail)  {
                    $this->detailPembelian->deleteByNoPembelianKodeProduk($detail->no_pembelian, $detail->kode_produk);
                });

                $this->pembelian->delete($pembelian->no_pembelian);

                return response()->json([
                    "success" => "Data Penjualan Berhasil Dihapus"
                ]);
            }
        }
}
