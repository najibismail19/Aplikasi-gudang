<?php

namespace App\Providers;

use App\Repository\DetailPembelianRepository;
use App\Repository\DetailPenerimaanRepository;
use App\Repository\Impl\DetailPembelianRepositoryImpl;
use App\Repository\Impl\DetailPenerimaanRepositoryImpl;
use App\Repository\Impl\KartuStokRepositoryImpl;
use App\Repository\Impl\MasterPrakitanRepositoryImpl;
use App\Repository\Impl\PembelianRepositoryImpl;
use App\Repository\Impl\PenerimaanRepositoryImpl;
use App\Repository\Impl\ProdukRepositoryImpl;
use App\Repository\Impl\StokRepositoryImpl;
use App\Repository\KartuStokRepository;
use App\Repository\MasterPrakitanRepository;
use App\Repository\PembelianRepository;
use App\Repository\PenerimaanRepository;
use App\Repository\ProdukRepository;
use App\Repository\StokRepository;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        ProdukRepository::class => ProdukRepositoryImpl::class,
        PembelianRepository::class => PembelianRepositoryImpl::class,
        DetailPembelianRepository::class => DetailPembelianRepositoryImpl::class,
        PenerimaanRepository::class => PenerimaanRepositoryImpl::class,
        DetailPenerimaanRepository::class => DetailPenerimaanRepositoryImpl::class,
        StokRepository::class => StokRepositoryImpl::class,
        KartuStokRepository::class => KartuStokRepositoryImpl::class,
        MasterPrakitanRepository::class => MasterPrakitanRepositoryImpl::class
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    public function provides()
    {
        return [
            ProdukRepository::class,
            PembelianRepository::class,
            DetailPembelianRepository::class,
            PenerimaanRepository::class,
            DetailPenerimaanRepository::class,
            StokRepository::class,
            KartuStokRepository::class,
            MasterPrakitanRepository::class
        ];
    }
}
