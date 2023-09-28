<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetailPembelianCreateRequest;
use App\Repository\DetailPembelianRepository;
use App\Repository\PembelianRepository;
use App\Rules\DupplicateProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
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

        if($pembelian == null || $pembelian->karyawan->nik != getNik() || $pembelian->status_pembelian == true){
            return abort(404);
        }

        if ($request->ajax()) {

            $details = $this->detailPembelian->findByNoPembelian($no_pembelian)->get();

            $total_keseluruhan = $this->detailPembelian->sum($no_pembelian);

            $jumlahProduk = count($details);

            $dataDetailPembelian = [];
            foreach($details as $detail) {
                $dataDetailPembelian[] = [
                    "no_pembelian" => $detail->no_pembelian,
                    "kode_produk" => $detail->kode_produk,
                    "nama_produk" => $detail->produk->nama,
                    "jenis_produk" => $detail->produk->jenis,
                    "harga" =>  $detail->harga,
                    "jumlah" => $detail->jumlah,
                    "total_harga" => $detail->total_harga,
                ];
            }

            return response()->json(["data" => $dataDetailPembelian,"total_keseluruhan" => $total_keseluruhan,"jumlah_jenis_produk" => $jumlahProduk]);
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

    public function store(request $request)
    {
        try {
            $validation = $request->validate([
                "no_pembelian" => "required",
                "kode_produk" => "required", new DupplicateProduk(),
                "harga" => "required|numeric|min:0|not_in:0",
                "jumlah" => "required|numeric|min:0|not_in:0",
                "total_harga" => "required|numeric|min:0|not_in:0"
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

            return response()->json(["errors" => $errors]);

        }
    }

    public function update(Request $request)
    {
        try {

            $validation = $request->validate([
                "no_pembelian" => "required",
                "kode_produk" => "required",
                "jumlah" => "required|min:0|not_in:0",
                "harga" => "required|min:0|not_in:0",
                "total_harga" => "required|min:0|not_in:0"
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

            $errors = $exception->validator->errors()->toArray();

            return response()->json(["errors" => $errors]);

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


    public function showDetail($no_pembelian, Request $request) : Response
    {
        $pembelian = $this->pembelian->getByDetailPembelianComplete($no_pembelian);

        if(!$pembelian){
            return abort(404);
        }

        $details = $this->detailPembelian->findByNoPembelian($pembelian->no_pembelian)->get();

        return response()->view("detail_pembelian.show_detail_pembelian", [
            "pembelian" => $pembelian,
            "details" => $details,
            "tanggal_pembelian" => Carbon::parse($pembelian->tanggal_pembelian)->isoFormat('dddd, D MMMM Y')
        ]);
    }
}
