<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailPembelianController;
use App\Http\Controllers\DetailPenerimaanController;
use App\Http\Controllers\DetailPenjualanController;
use App\Http\Controllers\DetailPrakitanController;
use App\Http\Controllers\KartuStokController;
use App\Http\Controllers\Laporan\LaporanDetailPembelianController;
use App\Http\Controllers\Laporan\LaporanDetailPenerimaanController;
use App\Http\Controllers\Laporan\LaporanDetailPrakitanController;
use App\Http\Controllers\Laporan\LaporanKartuStokController;
use App\Http\Controllers\Laporan\LaporanPembelianController;
use App\Http\Controllers\Laporan\LaporanPenerimaanController;
use App\Http\Controllers\Laporan\LaporanDetailPenjualanController;
use App\Http\Controllers\Laporan\LaporanPenjualanController;
use App\Http\Controllers\Laporan\LaporanPrakitanController;
use App\Http\Controllers\MasterPrakitanController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenerimaanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PrakitanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Models\DetailPembelian;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(["middleware" => "guest:karyawan"], function () {
    // Route::get("/auth/register", [AuthController::class, "register"]);
    // Route::post("/auth", [AuthController::class, "doRegister"]);
    Route::get("/auth/login", [AuthController::class, "login"])->name("login");
    Route::post("/auth/do-login", [AuthController::class, "doLogin"]);
});

Route::middleware(['auth:karyawan', 'rules_access'])->group(function () {

    //  Dashboard
    Route::get("/dashboard", [DashboardController::class, "index"]);
    Route::get("/dashboard/get-chart-pembelian", [DashboardController::class, "getChartPembelian"]);
    Route::get("/dashboard/get-chart-penjualan", [DashboardController::class, "getChartPenjualan"]);
    Route::get("/dashboard/get-chart-produk-terlaris", [DashboardController::class, "getChartProdukTerlaris"]);
    Route::get("/dashboard/get-chart-produk-terbanyak", [DashboardController::class, "getChartProdukTerbanyak"]);

    // Users
    Route::get("/users/log-authentication", [UserController::class, "logAuthentication"]);
    // Route::get("/users/users-activity", [UserController::class, "usersActivity"]);
    Route::get("/profile", [UserController::class, "profile"]);
    Route::get("/users", [UserController::class, "listUsers"]);
    Route::post("/users", [UserController::class, "store"]);
    Route::post("/users/update", [UserController::class, "update"]);



    // Produk
    Route::get("/produk", [ProdukController::class, "index"]);
    Route::post("/produk", [ProdukController::class, "store"]);
    Route::get("/produk/get-modal-add", [ProdukController::class, "getModalAdd"]);
    Route::get("/produk/get-modal-edit", [ProdukController::class, "getModalEdit"]);
    Route::post("/produk/update", [ProdukController::class, "update"]);
    Route::delete("/produk/{kode_produk}", [ProdukController::class, "delete"]);
    // End Produk

    // Supplier
    Route::get("/supplier", [SupplierController::class, "index"]);
    Route::post("/supplier", [SupplierController::class, "store"]);
    Route::post("/supplier/{id_supplier}", [SupplierController::class, "update"]);
    Route::delete("/supplier/{id_supplier}", [SupplierController::class, "delete"]);
    Route::get("/supplier/get-modal-add", [SupplierController::class, "getModalAdd"]);
    Route::get("/supplier/get-modal-edit", [SupplierController::class, "getModalEdit"]);

    // Customers
    Route::get("/customers", [CustomerController::class, "index"]);
    Route::post("/customers", [CustomerController::class, "store"]);
    Route::post("/customers/update", [CustomerController::class, "update"]);
    Route::delete("/customers/{id_customer}", [CustomerController::class, "delete"]);
    Route::get("/customers/get-modal-add", [CustomerController::class, "getModalAdd"]);
    Route::get("/customers/get-modal-edit", [CustomerController::class, "getModalEdit"]);



        // Pembelian
        Route::get("/pembelian", [PembelianController::class, "index"])->name("pembelian");
        Route::post("/pembelian", [PembelianController::class, "store"]);
        Route::delete("/pembelian/{no_pembelian}", [PembelianController::class, "delete"]);
        Route::get("/pembelian/tambah-pembelian", [PembelianController::class, "tambahPembelian"]);
        Route::get("/pembelian/get-modal-supplier", [PembelianController::class, "getModalSupplier"]);

        // Detail Pembelian
        Route::get("/pembelian/get-modal-produk", [DetailPembelianController::class, "getModalProduk"]);
        Route::post("/pembelian/produk/create", [DetailPembelianController::class, "store"]);
        Route::get("/pembelian/{no_pembelian}", [DetailPembelianController::class, "index"])->name("detail.pembelian");
        Route::post("/pembelian/detail-pembelian", [DetailPembelianController::class, "storeAllDetailPembelian"]);
        Route::get("/pembelian/show-detail/{no_pembelian}", [DetailPembelianController::class, "showDetail"]);
        Route::post("/pembelian/detail-pembelian/update", [DetailPembelianController::class, "update"]);
        Route::delete("/pembelian/{no_pembelian}/produk/{kode_produk}", [DetailPembelianController::class, "delete"]);



        // Penerimaan
        Route::get("/penerimaan", [PenerimaanController::class, "index"]);
        Route::post("/penerimaan", [PenerimaanController::class, "store"]);
    Route::get("/penerimaan/show-detail/{no_penerimaan}", [DetailPenerimaanController::class, "showDetail"]);
    Route::get("/penerimaan/tambah-penerimaan", [PenerimaanController::class, "tambahPenerimaan"]);
    Route::get("/penerimaan/search-penerimaan", [PenerimaanController::class, "searchPenerimaan"]);
    Route::get("/penerimaan/get-detail-pembelian/{no_pembelian}", [PenerimaanController::class, "getDetailPembelian"]);

    // Kartu Stok
    Route::get("/kartu-stok", [KartuStokController::class, "index"]);

    // Stok
    Route::get("/stok/barang-jadi", [StokController::class, "barangJadi"]);
    Route::get("/stok/barang-mentah", [StokController::class, "barangMentah"]);

    // Master Prakitan
    Route::get("/master-prakitan", [MasterPrakitanController::class, "index"]);
    Route::get("/master-prakitan/tambah-master-prakitan", [MasterPrakitanController::class, "tambahMasterPrakitan"]);
    Route::get("/master-prakitan/get-modal-produk-jadi", [MasterPrakitanController::class, "getModalProdukJadi"]);
    Route::get("/master-prakitan/cek-produk/{kode_produk}", [MasterPrakitanController::class, "cekProduk"]);
    Route::get("/master-prakitan/get-modal-produk-mentah", [MasterPrakitanController::class, "getModalProdukMentah"]);
    Route::get("/master-prakitan/get-detail-prakitan/{kode_produk_jadi}", [MasterPrakitanController::class, "getDetailMasterPerakitan"]);
    Route::post("/master-prakitan/detail-master-prakitan/store", [MasterPrakitanController::class, "store"]);
    Route::post("/master-prakitan/detail-master-prakitan/update", [MasterPrakitanController::class, "update"]);
    Route::delete("/master-prakitan/{kode_produk_jadi}/produk/{kode_produk_mentah}", [MasterPrakitanController::class, "delete"]);
    Route::post("/master-prakitan/store", [MasterPrakitanController::class, "storeAll"]);

    // Prakitan
    Route::get("/prakitan", [PrakitanController::class, "index"]);
    Route::post("/prakitan", [PrakitanController::class, "store"]);
    Route::get("/prakitan/tambah-prakitan", [PrakitanController::class, "tambahPrakitan"]);
    Route::get("/prakitan/get-master-prakitan", [PrakitanController::class, "getMasterPrakitan"]);
    Route::get("/prakitan/get-detail-master-prakitan/{kode_produk}", [PrakitanController::class, "getDataDetailMasterPrakitan"]);

    // Detail Prakitan
    Route::get("/prakitan/{no_prakitan}", [DetailPrakitanController::class, "index"]);
    Route::post("/prakitan/detail-prakitan/store", [DetailPrakitanController::class, "store"]);
    Route::get("/prakitan/show-detail/{no_prakitan}", [DetailPrakitanController::class, "showDetail"]);


    // Penjualan
    Route::get("/penjualan", [PenjualanController::class, "index"]);
    Route::delete("/penjualan/{no_penjualan}", [PenjualanController::class, "delete"]);
    Route::post("/penjualan", [PenjualanController::class, "store"]);
    Route::get("/penjualan/tambah-penjualan", [PenjualanController::class, "tambahPenjualan"]);
    Route::get("/penjualan/get-modal-customer", [PenjualanController::class, "getModalCustomer"]);


    // Detail Penjualan
    Route::get("/penjualan/get-modal-produk", [DetailPenjualanController::class, "getModalProduk"]);
    Route::get("/penjualan/{no_penjualan}", [DetailPenjualanController::class, "index"])->name("detail.penjualan");
    Route::post("/penjualan/produk/create", [DetailPenjualanController::class, "store"]);
    Route::post("/penjualan/detail-penjualan/update", [DetailPenjualanController::class, "update"]);
    Route::post("/penjualan/detail-penjualan", [DetailPenjualanController::class, "selesaiTransaksi"]);
    Route::delete("/penjualan/{no_penjualan}/produk/{kode_produk}", [DetailPenjualanController::class, "delete"]);
    Route::get("/penjualan/show-detail/{no_penjualan}", [DetailPenjualanController::class, "showDetail"]);

    // SECTION LAPORAN

    // Laporan Pembelian
    Route::get("/pembelian/print/cetak-laporan", [LaporanPembelianController::class, "cetakLaporan"]);
    Route::get("/pembelian/print/export-excel", [LaporanPembelianController::class, "exportExcel"]);


    // Laporan Detail Pembelian
    Route::get("/pembelian/detail-pembelian/print-pdf/{no_pembelian}", [LaporanDetailPembelianController::class, "cetakPDF"]);
    Route::get("/pembelian/detail-pembelian/download-excel/{no_pembelian}", [LaporanDetailPembelianController::class, "exportExcel"]);


    // Laporan Penerimaan
    Route::get("/penerimaan/print/cetak-laporan", [LaporanPenerimaanController::class, "cetakLaporan"]);
    Route::get("/penerimaan/print/export-excel", [LaporanPenerimaanController::class, "exportExcel"]);


    // Laporan Detail Penerimaan
    Route::get("/penerimaan/detail-penerimaan/print-pdf/{no_penerimaan}", [LaporanDetailPenerimaanController::class, "cetakLaporan"]);
    Route::get("/penerimaan/detail-penerimaan/download-excel/{no_penerimaan}", [LaporanDetailPenerimaanController::class, "exportExcel"]);


    // Laporan Kartu Stok
    Route::get("/kartu-stok/print/cetak-laporan", [LaporanKartuStokController::class, "cetakLaporan"]);
    Route::get("/kartu-stok/print/export-excel", [LaporanKartuStokController::class, "exportExcel"]);


    // Laporan Prakitan
    Route::get("/prakitan/print/cetak-laporan", [LaporanPrakitanController::class, "cetakLaporan"]);
    Route::get("/prakitan/print/export-excel", [LaporanPrakitanController::class, "exportExcel"]);

    // Laporan Detail Prakitan
    Route::get("/prakitan/detail-prakitan/print-pdf/{no_prakitan}", [LaporanDetailPrakitanController::class, "cetakLaporan"]);
    Route::get("/prakitan/detail-prakitan/download-excel/{no_prakitan}", [LaporanDetailPrakitanController::class, "exportExcel"]);


    // Laporan Penjualan
    Route::get("/penjualan/print/cetak-pdf", [LaporanPenjualanController::class, "cetakPDF"]);
    Route::get("/penjualan/print/export-excel", [LaporanPenjualanController::class, "exportExcel"]);

    // Laporan Detail Penjualan
    Route::get("/penjualan/print/detail-penjualan/print-pdf/{no_penjualan}", [LaporanDetailPenjualanController::class, "cetakPDF"]);
    Route::get("/penjualan/detail-prakitan/export-excel/{no_penjualan}", [LaporanDetailPenjualanController::class, "exportExcel"]);

    // Logout
    Route::get("/users/logout", [AuthController::class, "logout"]);

});
