<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailPembelianController;
use App\Http\Controllers\KartuStokController;
use App\Http\Controllers\MasterPrakitanController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenerimaanController;
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
    Route::get("/auth/register", [AuthController::class, "register"]);
    Route::post("/auth", [AuthController::class, "doRegister"]);
    Route::get("/auth/login", [AuthController::class, "login"])->name("login");
    Route::post("/auth/do-login", [AuthController::class, "doLogin"]);
});

Route::group(["middleware" => "auth:karyawan"], function () {
    //  Dashboard
    Route::get("/dashboard", [DashboardController::class, "index"]);
    // Users
    Route::get("/users/log-authentication", [UserController::class, "logAuthentication"]);
    Route::get("/users/users-activity", [UserController::class, "usersActivity"]);
    Route::get("/users/profile", [UserController::class, "profile"]);



    // Produk
    Route::get("/produk", [ProdukController::class, "index"]);
    Route::post("/produk", [ProdukController::class, "store"]);
    Route::get("/produk/get-modal-add", [ProdukController::class, "getModalAdd"]);
    Route::get("/produk/get-modal-edit", [ProdukController::class, "getModalEdit"]);
    Route::post("/produk/{kode_produk}", [ProdukController::class, "update"]);
    Route::delete("/produk/{kode_produk}", [ProdukController::class, "delete"]);
    // End Produk

    // Supplier
    Route::get("/supplier", [SupplierController::class, "index"]);
    Route::post("/supplier", [SupplierController::class, "store"]);
    Route::post("/supplier/{id_supplier}", [SupplierController::class, "update"]);
    Route::delete("/supplier/{id_supplier}", [SupplierController::class, "delete"]);
    Route::get("/supplier/get-modal-add", [SupplierController::class, "getModalAdd"]);
    Route::get("/supplier/get-modal-edit", [SupplierController::class, "getModalEdit"]);


    // Pembelian
    Route::get("/pembelian", [PembelianController::class, "index"]);
    Route::post("/pembelian", [PembelianController::class, "store"]);
    Route::get("/pembelian/tambah-pembelian", [PembelianController::class, "tambahPembelian"]);
    Route::get("/pembelian/get-modal-supplier", [PembelianController::class, "getModalSupplier"]);

    // Detail Pembelian
    Route::get("/pembelian/get-modal-produk", [DetailPembelianController::class, "getModalProduk"]);
    Route::get("/pembelian/{no_pembelian}", [DetailPembelianController::class, "index"])->name("detail.pembelian");
    Route::post("/pembelian/detail-pembelian", [DetailPembelianController::class, "storeAllDetailPembelian"]);
    Route::post("/pembelian/produk", [DetailPembelianController::class, "store"]);
    Route::post("/pembelian/detail-pembelian/update", [DetailPembelianController::class, "update"]);
    Route::delete("/pembelian/{no_pembelian}/produk/{kode_produk}", [DetailPembelianController::class, "delete"]);



    // Penerimaan
    Route::get("/penerimaan", [PenerimaanController::class, "index"]);
    Route::post("/penerimaan", [PenerimaanController::class, "store"]);
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
    Route::get("/master-prakitan/get-modal-produk-mentah", [MasterPrakitanController::class, "getModalProdukMentah"]);
    Route::get("/master-prakitan/get-detail-prakitan/{kode_produk_jadi}", [MasterPrakitanController::class, "getDetailMasterPerakitan"]);
    Route::post("/master-prakitan/detail-master-prakitan/store", [MasterPrakitanController::class, "store"]);
    Route::post("/master-prakitan/detail-master-prakitan/update", [MasterPrakitanController::class, "update"]);
    Route::delete("/master-prakitan/{kode_produk_jadi}/produk/{kode_produk_mentah}", [MasterPrakitanController::class, "delete"]);
    Route::post("/master-prakitan/store", [MasterPrakitanController::class, "storeAll"]);



    // Logout
    Route::get("/users/logout", [AuthController::class, "logout"]);
});
