<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Stok extends Pivot
{
    protected $table = "stok";
    protected $foreignKey = "id_gudang";
    protected $reletedKey = "kode_produk";
    public $timestamps = false;

    protected $fillable = [
        "id_gudang",
        "kode_produk",
        "stok",
    ];

    public function produk() : BelongsTo
    {
        return $this->belongsTo(Produk::class, "kode_produk", "kode_produk");
    }

    public function gudang() : BelongsTo
    {
        return $this->belongsTo(Gudang::class, "id_gudang", "id_gudang");
    }
}
