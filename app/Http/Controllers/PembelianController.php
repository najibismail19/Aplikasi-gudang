<?php

namespace App\Http\Controllers;

use App\Repository\PembelianRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class PembelianController extends Controller
{
    private PembelianRepository $pembelian;

    public function __construct(PembelianRepository $pembelian) {
        $this->pembelian = $pembelian;
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
            $view = view('pembelian.get-modal-supplier')->render();
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
}
