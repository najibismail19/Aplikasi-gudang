<?php

namespace App\Http\Controllers;

use App\Repository\DetailPembelianRepository;
use App\Repository\PembelianRepository;
use App\Rules\DupplicateProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class DetailPembelianController extends Controller
{

    private PembelianRepository $pembelian;

    private DetailPembelianRepository $detailPembelian;

    public function __construct(PembelianRepository $pembelian, DetailPembelianRepository $detailPembelian) {

        $this->pembelian = $pembelian;

        $this->detailPembelian = $detailPembelian;

    }


    public function index(Request $request, $no_pembelian) : mixed
    {
        $pembelian = $this->pembelian->find($no_pembelian);

        if($pembelian == null || $pembelian->karyawan->nik != Auth::guard("karyawan")->user()->nik || $pembelian->status_pembelian == true){
            return abort(404);
        }

        if ($request->ajax()) {
            $data = $this->detailPembelian->findByNoPembelian($no_pembelian);

            return $this->detailPembelian->getDatatable($data);
        }

        return response()->view("detail_pembelian.detail_pembelian",[
            "pembelian" => $pembelian,
            "tanggal_pembelian" => Carbon::parse($pembelian->tanggal_pembelian)->format("Y-m-d")
        ]);
    }

    public function getModalProduk(Request $request)
    {
        if($request->ajax()) {
            $view = view('detail_pembelian.get-modal-produk')->render();
            return response()->json( array('success' => true, 'modal'=> $view));
        }
    }

    public function store(Request $request)
    {
        try {
            $validation = $request->validate([
                "no_pembelian" => "required",
                "kode_produk" => new DupplicateProduk(),
                "harga" => "required|numeric",
                "jumlah" => "required|numeric",
                "total_harga" => "required|numeric"
            ]);

            $no_pembelian = $request->input("no_pembelian");
            $kode_produk = $request->input("kode_produk");
            $content = [
                    "harga"          => $request->input("harga"),
                    "jumlah"         => $request->input("jumlah"),
                    "total_harga"    => $request->input("total_harga")
            ];

            $this->pembelian->insertPivotDetailPembelian($no_pembelian, $kode_produk, $content);

            $total_keseluruhan = $this->detailPembelian->sum($no_pembelian);

            $this->pembelian->update($no_pembelian, [
                "total_keseluruhan" => $total_keseluruhan
            ]);

            return response()->json(["success" => "Produk Berhasil Ditambahkan", "total_keseluruhan" => $total_keseluruhan]);

        } catch (ValidationException $exception) {

            $errors = $exception->validator->errors()->toArray();

            return response()->json(["error" => $errors["kode_produk"]]);

        }
    }

    public function update(Request $request)
    {
        try {

            $validation = $request->validate([
                "no_pembelian" => "required",
                "kode_produk" => "required",
                "jumlah" => "required",
                "harga" => "required",
                "total_harga" => "required"
            ]);

            $no_pembelian = $request->input("no_pembelian");
            $kode_produk = $request->input("kode_produk");

            $content = [
                "jumlah"         => $request->input("jumlah"),
                "harga"          => $request->input("harga"),
                "total_harga"    => $request->input("total_harga")
            ];

            $this->pembelian->updatePivotDetailPembelian($no_pembelian, $kode_produk, $content);

            $total_keseluruhan = $this->detailPembelian->sum($no_pembelian);

            $this->pembelian->update($no_pembelian, [
                "total_keseluruhan" => $total_keseluruhan
            ]);

            return response()->json(["success" => "Produk Berhasil di Update", "total_keseluruhan" => $total_keseluruhan]);

        } catch (ValidationException $exception) {

            return response()->json(["error" => "Produk Gagal di update"]);

        }
    }

    public function delete(Request $request, $no_pembelian, $kode_produk) : JsonResponse
    {
        if($request->ajax()) {

            $purchase_detail = $this->detailPembelian->findByNoPembelianKodeProduk($no_pembelian, $kode_produk);

            if($purchase_detail) {

                $deleteDetailPembelian = $this->detailPembelian->deleteByNoPembelianKodeProduk($no_pembelian, $kode_produk);

                $total_keseluruhan = $this->detailPembelian->sum($no_pembelian);

                $this->pembelian->update($no_pembelian, [
                    "total_keseluruhan" => $total_keseluruhan
                ]);

                if($deleteDetailPembelian) {
                    return response()->json(["success" => "Produk Dengan Kode {$kode_produk} Berhasil Dihapus"]);
                }
            } else {
                return response()->json(["error" => "Gagal Menghapus"]);
            }

        }
    }

    public function storeAllDetailPembelian(Request $request) : JsonResponse
    {
        if($request->ajax()) {

            $pembelian = $this->pembelian->find($request->input("no_pembelian"));

                if(count($pembelian->detailPembelian) == 0)
                {
                    return response()->json(["error" => "Data Produk Tidak Bolek Kosong"]);
                }

                $this->pembelian->update($pembelian->no_pembelian, [
                    "status_pembelian" => true
                ]);

            return response()->json(["success" => "Pembelian Sudah Di Selesaikan"]);
        }
    }
}
