<?php

namespace App\Http\Controllers;

use App\Repository\MasterPrakitanRepository;
use App\Rules\DupplicateMasterPrakitan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class MasterPrakitanController extends Controller
{

    private MasterPrakitanRepository $masterPrakitan;

    public function __construct(MasterPrakitanRepository $masterPrakitan)
    {
        $this->masterPrakitan = $masterPrakitan;
    }

    public function index(Request $request)
    {
        if($request->ajax()) {
            return $this->masterPrakitan->getDatatable();
        }

        return response()->view("master-prakitan.master-prakitan");
    }

    public function tambahMasterPrakitan()
    {
        return response()->view("master-prakitan.tambah-master-prakitan");
    }

    function getModalProdukJadi(Request $request)
    {
        if($request->ajax()) {
            $view = view('master-prakitan.search-produk-jadi')->render();
            return response()->json( array('success' => true, 'modal'=> $view));
        }
    }

    function getModalProdukMentah(Request $request)
    {
        if($request->ajax()) {
            $view = view('master-prakitan.search-produk-mentah')->render();
            return response()->json( array('success' => true, 'modal'=> $view));
        }
    }

    public function getDetailMasterPerakitan(Request $request, $kode_produk_jadi) : JsonResponse
    {
        if($request->ajax()) {
            $detail_master = $this->masterPrakitan->getDetailMaster($kode_produk_jadi);
            $data = [];

            foreach ($detail_master as $detail) {
                $data[] = [
                    "kode_produk" => $detail->kode_produk_mentah,
                    "kode_produk_jadi" => $detail->kode_produk_jadi,
                    "nama_produk" => $detail->produk_mentah->nama,
                    "satuan" => $detail->produk_mentah->satuan,
                    "quantity" => $detail->quantity,
                ];
            }
            return response()->json( array('success' => true, 'data'=> $data));
        }
    }

    public function store(Request $request) : JsonResponse
    {
        if($request->ajax()) {
            try {
                $data = $request->validate([
                    "kode_produk_jadi" => ["required"],
                    "kode_produk_mentah" => ["required", new DupplicateMasterPrakitan()],
                    "quantity" => ["required", "numeric", "min:0", "not_in:0"]
                ]);

                $this->masterPrakitan->insert([
                    "kode_produk_jadi" => $data["kode_produk_jadi"],
                    "kode_produk_mentah" => $data["kode_produk_mentah"],
                    "quantity" => $data["quantity"],
                ]);

                return response()->json( array('success' => "Data Master Perakitan Berhasil Ditambahkan"));

            } catch( ValidationException $exception) {

                $errors = $exception->validator->errors()->toArray();

                return response()->json(["errors" => $errors]);
            }

        }
    }

    public function update(Request $request) : JsonResponse
    {
        if($request->ajax()) {
            try {
                $data = $request->validate([
                    "kode_produk_jadi" => ["required"],
                    "kode_produk_mentah" => ["required"],
                    "quantity" => ["required", "numeric", "min:0", "not_in:0"]
                ]);

                $this->masterPrakitan->update($data["kode_produk_jadi"], $data["kode_produk_mentah"], [
                    "quantity" => $data["quantity"],
                ]);

                return response()->json( array('success' => "Data Master Perakitan Berhasil Diupdate"));

            } catch( ValidationException $exception) {

                $errors = $exception->validator->errors()->toArray();

                return response()->json(["errors" => $errors]);
            }
        }
    }

    public function delete(Request $request, $kode_produk_jadi, $kode_produk_mentah) : JsonResponse
    {
        if($request->ajax()) {

            $this->masterPrakitan->delete($kode_produk_jadi, $kode_produk_mentah);

            return response()->json(array("success" => "Produk Berhasil Di hapus"));
        }
    }

    public function storeAll(Request $request) : JsonResponse
    {
        if($request->ajax()) {

            $kode_produk_jadi = $request->input("kode_produk_jadi");

            $produkAll = $this->masterPrakitan->updateManyIsActive($kode_produk_jadi);

            return response()->json(array("success" => "Master Prakitan Behasil ditambahkan"));
        }
    }

    public function cekProduk($kode_produk, Request $request)
    {
        if($request->ajax()){

            $data = $this->masterPrakitan->getDetailMasterIsActive($kode_produk);

            if(count($data) > 0) {
                return response()->json(["error" => "Produk sudah pernah dirakit"]);
            }

            return response()->json(["success" => true]);
        }
    }
}
