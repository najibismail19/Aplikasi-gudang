<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DetailPenjualan extends Pivot
{
    protected $table = "detail_penjualan";
    protected $foreignKey = "no_penjualan";
    protected $reletedKey = "kode_produk";
    public $timestamps = false;

    protected $guarded = [];

    public function produk() : BelongsTo
    {
        return $this->belongsTo(Produk::class, "kode_produk", "kode_produk");
    }

    public function penjualan() : BelongsTo
    {
        return $this->belongsTo(Penjualan::class, "no_penjualan", "no_penjualan");
    }
}
