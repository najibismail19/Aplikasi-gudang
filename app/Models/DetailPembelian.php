<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DetailPembelian extends Pivot
{
    use HasFactory;

    protected $table = "detail_pembelian";
    protected $foreignKey = "no_pembelian";
    protected $reletedKey = "kode_produk";
    public $timestamps = false;

    protected $guarded = [];

    public function produk() : BelongsTo
    {
        return $this->belongsTo(Produk::class, "kode_produk", "kode_produk");
    }

    public function pembelian() : BelongsTo
    {
        return $this->belongsTo(Pembelian::class, "no_pembelian", "no_pembelian");
    }
}
