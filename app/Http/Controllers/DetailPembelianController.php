<?php

namespace App\Http\Controllers;

use App\Models\DetailPembelian;
use App\Models\Pembelian;
use App\Rules\DupplicateProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class DetailPembelianController extends Controller
{
    public function index(Request $request, $no_pembelian) : mixed
    {
        $pembelian = Pembelian::find($no_pembelian);
        if($pembelian == null || $pembelian->karyawan->nik != Auth::guard("karyawan")->user()->nik || $pembelian->status_pembelian == true){
            return abort(404);
        }

        if ($request->ajax()) {
            $detailPembelian = DetailPembelian::select("*")->with(["produk"])->where("no_pembelian", $no_pembelian);
            return DataTables::of($detailPembelian)
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

            $pembelian = Pembelian::find($request->input("no_pembelian"));

            $result = $pembelian->detailPembelian()->attach($request->input("kode_produk"), [
                "harga"          => $request->input("harga"),
                "jumlah"         => $request->input("jumlah"),
                "total_harga"    => $request->input("total_harga")
            ]);

            $total_keseluruhan = DetailPembelian::where("no_pembelian", $request->input("no_pembelian"))->get()
            ->sum(function ($detail) {
                return (float) str_replace(',', '', $detail->total_harga);
            });

            $pembelian->total_keseluruhan = $total_keseluruhan;
            $pembelian->update();

            return response()->json(["success" => "Produk Berhasil Ditambahkan", "total_keseluruhan" => $total_keseluruhan]);

        } catch (ValidationException $exception) {

            $errors = $exception->validator->errors()->toArray();

            return response()->json(["error" => $errors["kode_produk"]]);

        }
    }

    public function update(Request $request, $no_pembelian, $kode_produk)
    {
        try {

            $validation = $request->validate([
                "no_pembelian" => "required",
                "kode_produk" => "required",
                "jumlah" => "required",
                "harga" => "required",
                "total_harga" => "required"
            ]);

            $query = DetailPembelian::where("no_pembelian", $no_pembelian)
                             ->where("kode_produk", $kode_produk)
                             ->update([
                                "jumlah"         => $request->input("jumlah"),
                                "harga"          => $request->input("harga"),
                                "total_harga"    => $request->input("total_harga")
                             ]);

            $total_keseluruhan = DetailPembelian::where("no_pembelian", $no_pembelian)->get()
            ->sum(function ($detail) {
                return (float) str_replace(',', '', $detail->total_harga);
            });

            $pembelian = Pembelian::find($no_pembelian);
            $pembelian->total_keseluruhan = $total_keseluruhan;
            $pembelian->update();

            return response()->json(["success" => "Produk Berhasil di Update", "total_keseluruhan" => $total_keseluruhan]);

        } catch (ValidationException $exception) {

            return response()->json(["error" => "Produk Gagal di update"]);

        }
    }

    public function delete(Request $request, $no_pembelian, $kode_produk) : JsonResponse
    {
        if($request->ajax()) {
            $purchase_detail = DetailPembelian::where("no_pembelian", $no_pembelian)
                                    ->where("kode_produk", $kode_produk)
                                    ->first();
            if($purchase_detail) {
                $query =  DetailPembelian::where("no_pembelian", $no_pembelian)
                                        ->where("kode_produk", $kode_produk)
                                        ->delete();
                if($query) {
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
            $pembelian = Pembelian::find($request->input("no_pembelian"));
                if(count($pembelian->detailPembelian) == 0)
                {
                    return response()->json(["error" => "Data Produk Tidak Bolek Kosong"]);
                }

                $pembelian->status_pembelian = true;
                $pembelian->update();

            return response()->json(["success" => "Pembelian Sudah Di Selesaikan"]);
        }
    }
}
