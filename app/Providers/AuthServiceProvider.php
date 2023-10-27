<?php

namespace App\Providers;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Gate;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

        Gate::define('pembelian', function (Karyawan $karyawan ){
            $jabatan = $karyawan->jabatan->nama_jabatan;
            return ($jabatan == "Staff Pembelian" || $jabatan == "Admin" || $jabatan == "Supervisor Gudang" || $jabatan == "Manajer Gudang");
        });

        Gate::define('penerimaan', function (Karyawan $karyawan ){
            $jabatan = $karyawan->jabatan->nama_jabatan;
            return ($jabatan == "Staff Penerimaan" || $jabatan == "Admin" || $jabatan == "Supervisor Gudang" || $jabatan == "Manajer Gudang");
        });

        Gate::define('penjualan', function (Karyawan $karyawan ){
            $jabatan = $karyawan->jabatan->nama_jabatan;
            return ($jabatan == "Staff Penjualan" || $jabatan == "Admin" || $jabatan == "Supervisor Gudang" || $jabatan == "Manajer Gudang");
        });

        Gate::define('prakitan', function (Karyawan $karyawan ){
            $jabatan = $karyawan->jabatan->nama_jabatan;
            return ($jabatan == "Operator Prakitan" || $jabatan == "Admin" || $jabatan == "Supervisor Gudang" || $jabatan == "Manajer Gudang");
        });

        Gate::define('management_users', function (Karyawan $karyawan ){
            $jabatan = $karyawan->jabatan->nama_jabatan;
            return ($jabatan == "Admin" || $jabatan == "Supervisor Gudang" || $jabatan == "Manajer Gudang");
        });
    }
}
