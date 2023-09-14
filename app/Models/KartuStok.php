<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class KartuStok extends Pivot {
    use HasFactory;

     protected $table = "kartu_stok";
    protected $foreignKey = "id_gudang";
    protected $reletedKey = "kode_produk";
    public $timestamps = false;

    protected $guarded = [];

    public function produk() : BelongsTo
    {
        return $this->belongsTo(Produk::class, "kode_produk", "kode_produk");
    }

    public function gudang() : BelongsTo
    {
        return $this->belongsTo(Gudang::class, "id_gudang", "id_gudang");
    }
}
