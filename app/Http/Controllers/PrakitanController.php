<?php

namespace App\Http\Controllers;

use App\Repository\KartuStokRepository;
use App\Repository\MasterPrakitanRepository;
use App\Repository\PrakitanRepository;
use App\Repository\StokRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PrakitanController extends Controller
{

    private MasterPrakitanRepository $masterPrakitan;
    private StokRepository $stok;
    private KartuStokRepository $kartuStok;
    private PrakitanRepository $prakitan;

    public function __construct(MasterPrakitanRepository $masterPrakitan, StokRepository $stok, KartuStokRepository $kartuStok, PrakitanRepository $prakitan)
    {
        $this->masterPrakitan = $masterPrakitan;
        $this->stok = $stok;
        $this->kartuStok = $kartuStok;
        $this->prakitan = $prakitan;
    }

    public function index() {

        if(request()->ajax()) {

            return $this->prakitan->getDatatable();

        }

        return response()->view("prakitan.prakitan");
    }

    public function tambahPrakitan() {
        return response()->view("prakitan.tambah-prakitan", [
            "no_prakitan" => generateNo(code : "PRX", table : "prakitan")
        ]);
    }

    public function getMasterPrakitan(Request $request)
    {
        if($request->ajax()) {
            $view = view('prakitan.search-master-prakitan',[
                "produk_master_prakitan" => $this->masterPrakitan->getAll()
            ])->render();
            return response()->json( array('success' => true, 'modal'=> $view));
        }
    }

    public function getDataDetailMasterPrakitan(Request $request, $kode_produk)
    {
        if($request->ajax()) {
            $detail_master = $this->masterPrakitan->getDetailMasterIsActive($kode_produk);
            $data = [];
            foreach($detail_master as $detail) {
                $data[] = [
                    "kode_produk" => $detail->kode_produk_mentah,
                    "nama" => $detail->produk_mentah->nama,
                    "qty" => $detail->quantity,
                ];
            }
            return response()->json( array('success' => true, 'data'=> $data));
        }
    }

    public function store(Request $request)
    {
        if($request->ajax()) {
            try {

                try {
                    $validation = $request->validate([
                        "no_prakitan" => "required|unique:prakitan",
                        "kode_produk_jadi" => "required",
                        "nik" => "required",
                        "tanggal_rencana" => "required",
                        "qty_rencana" => "required|min:0|not_in:0",
                        "deskripsi" => "nullable"
                    ]);
                } catch (ValidationException $exception) {

                    $errors = $exception->validator->errors()->toArray();

                    return response()->json(["error_input" => $errors]);
                }

                $kode_produk_jadi = $validation["kode_produk_jadi"];

                $detail_master = $this->masterPrakitan->getDetailMasterIsActive($kode_produk_jadi);

                $data = [];

                foreach($detail_master as $detail) {
                    $stok = $this->stok->findByLockGudangProduk(getIdGudang(), $detail->kode_produk_mentah);

                    if($stok) {
                        $total_qty = $request->input("qty_rencana") * $detail->quantity;
                        if($stok->stok - $total_qty < 0) {
                            $data[] = [
                                "kode_produk" => $detail->kode_produk_mentah,
                            ];
                        }
                    } else {
                        $data[] = [
                            "kode_produk" => $detail->kode_produk_mentah,
                        ];
                    }
                }

                if(count($data) > 0) {
                    return response()->json(array("error_stok" => $data));
                }

            DB::beginTransaction();

            $this->prakitan->insert([
                "no_prakitan" => $validation["no_prakitan"],
                "kode_produk" => $validation["kode_produk_jadi"],
                "nik" => $validation["nik"],
                "tanggal_rencana" => $validation["tanggal_rencana"],
                "qty_rencana" => $validation["qty_rencana"]
                // "deskripsi" => $validation["deskripsi"],
            ]);


                $detail_master->each(function ($detail) use ($request) {
                    $total_qty = $request->input("qty_rencana") * $detail->quantity;

                    $this->stok->update(getIdGudang(), $detail->kode_produk_mentah, [
                        "stok" => DB::raw("stok - $total_qty")
                    ]);

                    $kartu_stock = $this->kartuStok->findByGudangProduk(getIdGudang(), $detail->kode_produk_mentah);

                            if($kartu_stock) {
                                $dataKartuStok = [
                                        "id_gudang" => getIdGudang(),
                                        "kode_produk" => $detail->kode_produk_mentah,
                                        "no_referensi" => $request->input("no_prakitan"),
                                        "saldo_awal" => $kartu_stock->saldo_akhir,
                                        "stock_in" => 0,
                                        "stock_out" => $total_qty,
                                        "saldo_akhir" => DB::raw("saldo_awal - $total_qty"),
                                        "deskripsi" => ""
                                    ];
                                $this->kartuStok->insert($dataKartuStok);
                            }

                            $this->prakitan->insertPivotDetailPrakitan($request->no_prakitan, $detail->kode_produk_mentah, [
                                "qty" => 0
                            ]);
                  });
                DB::commit();
                return response()->json(array("success" => "Prakitan Berhasil Ditambahkan"));
            } catch (\Throwable $e) {
                DB::rollBack();
                return response()->json(array("error_sql" => $e->getMessage()));
            }
        }
    }
}
