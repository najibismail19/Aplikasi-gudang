<?php

namespace App\Http\Controllers;

use App\Repository\DetailPenjualanRepository;
use App\Repository\KartuStokRepository;
use App\Repository\PenjualanRepository;
use App\Repository\ProdukRepository;
use App\Repository\StokRepository;
use App\Rules\DupplicateProduk;
use App\Rules\DupplicateProdukPenjualan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DetailPenjualanController extends Controller
{
    private PenjualanRepository $penjualan;

    private DetailPenjualanRepository $detailPenjualan;
    private KartuStokRepository $kartuStok;
    private StokRepository $stok;

    private ProdukRepository $produk;

    public function __construct(PenjualanRepository $penjualan, DetailPenjualanRepository $detailPenjualan, ProdukRepository $produk, KartuStokRepository $kartuStok, StokRepository $stok)
    {
        $this->penjualan = $penjualan;

        $this->detailPenjualan = $detailPenjualan;

        $this->produk = $produk;
        $this->kartuStok = $kartuStok;
        $this->stok = $stok;
    }


    public function index($no_penjualan, Request $request)
    {
        $penjualan = $this->penjualan->findByNoPenjualan($no_penjualan);

        if($penjualan->nik != getNik() || $penjualan->status_penjualan == true) {
            return abort(404);
        }

        if($request->ajax()) {
            $details = $this->detailPenjualan->ByNoPenjualan($no_penjualan);

            $total_keseluruhan = $this->detailPenjualan->sum($no_penjualan);

            $dataDetailPenjualan = [];

            foreach($details as $detail) {

                $dataDetailPenjualan[] = [
                    "no_penjualan" => $detail->no_penjualan,
                    "kode_produk" => $detail->kode_produk,
                    "nama_produk" => $detail->produk->nama,
                    "jenis_produk" => $detail->produk->jenis,
                    "harga" =>  $detail->harga,
                    "jumlah" => $detail->jumlah,
                    "diskon" => $detail->diskon,
                    "total_harga" =>  $detail->total_harga,
                ];
            }

            return response()->json(["data" => $dataDetailPenjualan, "total_keseluruhan" => $total_keseluruhan]);
        }

        return response()->view("detail_penjualan.detail_penjualan", [
            "penjualan" => $penjualan,
            "tanggal_penjualan" => Carbon::parse($penjualan->tanggal_penjualan)->isoFormat('D MMMM Y'),
        ]);

    }

    public function getModalProduk(Request $request)
    {
        if($request->ajax()){
            $view = view('detail_penjualan.get-modal-produk',[
                "produk" => $this->produk->getAll()
            ])->render();
            return response()->json( array('success' => true, 'modal'=> $view));
        }
    }

    public function store(request $request)
    {
        try {
            $data = $request->validate([
                "no_penjualan" => "required",
                "kode_produk" => ["required", function (string $attributes, string $value, Closure $fail) use ($request) {
                   if($this->detailPenjualan->ByNoPenjualanKodeProduk($request->input("no_penjualan"), $value)){
                        $fail("Produk Sudah Tersedia");
                   }
                }],
                "harga" => "required|numeric|min:0|not_in:0",
                "jumlah" => "required|numeric|min:0|not_in:0",
                "diskon" => "nullable|numeric|max:100",
                "total_harga" => "required|numeric|min:0|not_in:0"
            ]);

            $no_penjualan = $request->input("no_penjualan");
            $kode_produk = $request->input("kode_produk");

            $content = [
                    "harga"          => $request->input("harga"),
                    "jumlah"         => $request->input("jumlah"),
                    "diskon"         => $request->input("diskon"),
                    "total_harga"    => $request->input("total_harga")
            ];

            $this->penjualan->insertPivotDetailPejualan($no_penjualan, $kode_produk, $content);

            $total_keseluruhan = $this->detailPenjualan->sum($no_penjualan);

            $this->penjualan->update($no_penjualan, [
                "total_keseluruhan" => $total_keseluruhan
            ]);

            return response()->json(["success" => "Produk Berhasil Ditambahkan", "total_keseluruhan" => $total_keseluruhan]);

        } catch (ValidationException $exception) {

            $errors = $exception->validator->errors()->toArray();

            return response()->json(["errors" => $errors]);

        }
    }

    public function update(Request $request) {
            try {
                $validation = $request->validate([
                    "no_penjualan" => "required",
                    "kode_produk" => ["required"],
                    "harga" => "required|numeric|min:0|not_in:0",
                    "jumlah" => "required|numeric|min:0|not_in:0",
                    "diskon" => "nullable|numeric|max:100",
                    "total_harga" => "required|numeric|min:0|not_in:0"
                ]);

                $no_penjualan = $request->input("no_penjualan");
                $kode_produk = $request->input("kode_produk");

                $content = [
                    "jumlah"         => $request->input("jumlah"),
                    "harga"          => $request->input("harga"),
                    "diskon"    => $request->input("diskon"),
                    "total_harga"    => $request->input("total_harga")
                ];

                $this->penjualan->updatePivotDetailPenjualan($no_penjualan, $kode_produk, $content);

                $total_keseluruhan = $this->detailPenjualan->sum($request->input("no_penjualan"));

                $this->penjualan->update($no_penjualan, [
                    "total_keseluruhan" => $total_keseluruhan
                ]);

                return response()->json(["success" => "Produk Berhasil di Update", "total_keseluruhan" => $total_keseluruhan]);

            } catch(ValidationException $exception) {

                $errors = $exception->validator->errors()->toArray();

                return response()->json(["errors" => $errors]);

            }
    }

    public function delete($no_penjualan, $kode_produk, Request $request)
    {
        if($request->ajax()) {
            $detail_penjualan = $this->detailPenjualan->ByNoPenjualanKodeProduk($no_penjualan, $kode_produk);

            if($detail_penjualan) {

                $deleteDetailPembelian = $this->detailPenjualan->deleteByNoPenjualanKodeProduk($no_penjualan, $kode_produk);

                $total_keseluruhan = $this->detailPenjualan->sum($no_penjualan);

                $this->penjualan->update($no_penjualan, [
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

    public function selesaiTransaksi(Request $request)
    {
        if($request->ajax()) {
            $penjualan = $this->penjualan->findByNoPenjualan($request->input("no_penjualan"));
            try {

                $data = [];

                $details = $this->detailPenjualan->ByNoPenjualan($penjualan->no_penjualan);

                foreach($details as $detail) {
                    $stok = $this->stok->findByLockGudangProduk(getIdGudang(), $detail->kode_produk);

                    if($stok) {
                        if($stok->stok - $detail->jumlah < 0) {
                            $data[] = [
                                "kode_produk" => $detail->kode_produk,
                            ];
                        }
                    } else {
                        $data[] = [
                            "kode_produk" => $detail->kode_produk,
                        ];
                    }
                }

                if(count($data) > 0) {
                    return response()->json(array("error_stok" => $data));
                }

                DB::beginTransaction();

                if(count($penjualan->detailPenjualan) == 0)
                {
                    return response()->json(["error" => "Data Produk Tidak Bolek Kosong"]);
                }

                $this->penjualan->update($penjualan->no_penjualan, [
                    "status_penjualan" => true
                ]);


                $details->each( function ($detail) use ($request) {

                $stok = $this->stok->findByGudangProduk(getIdGudang(), $detail->kode_produk);

                $cek_stok = $stok->stok - $detail->jumlah;

                    if($cek_stok > 0) {
                        $kartu_stock = $this->kartuStok->findByGudangProduk(getIdGudang(), $detail->kode_produk);

                        if($kartu_stock) {

                            $dataKartuStok = [
                                    "id_gudang" => getIdGudang(),
                                    "kode_produk" => $detail->kode_produk,
                                    "no_referensi" => $detail->no_penjualan,
                                    "saldo_awal" => $kartu_stock->saldo_akhir,
                                    "stock_in" => 0,
                                    "stock_out" => $detail->jumlah,
                                    "saldo_akhir" => DB::raw("saldo_awal - {$detail->jumlah}"),
                                    "deskripsi" => "Penjualan"
                                ];

                            $this->kartuStok->insert($dataKartuStok);
                        }


                        $this->stok->update(getIdGudang(), $detail->kode_produk, [
                            "stok" => DB::raw("stok - $detail->jumlah")
                        ]);


                        }

                });

                DB::commit();

                return response()->json(["success" => "Prakitan Berhasil Terselesaikan"]);
            } catch (\Throwable $e) {

                DB::rollBack();

                return response()->json(["error_sql" => $e->getMessage()]);

            }
        }
    }

    public function showDetail($no_penjualan, Request $request) : Response
    {
        $penjualan = $this->penjualan->getByDetailPenjualanComplete($no_penjualan);

        if(!$penjualan){
            return abort(404);
        }

        $details = $this->detailPenjualan->findByNoPenjualan($penjualan->no_penjualan)->get();

        return response()->view("detail_penjualan.show_detail_penjualan", [
            "penjualan" => $penjualan,
            "details" => $details,
            "tanggal_penjualan" => Carbon::parse($penjualan->tanggal_penjualan)->isoFormat('D MMMM Y')
        ]);
    }

}
