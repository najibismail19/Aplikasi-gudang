<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DetailPrakitan extends Pivot
{
    use HasFactory;

    protected $table = "detail_prakitan";
    protected $foreignKey = "no_prakitan";
    protected $reletedKey = "kode_produk";
    public $timestamps = false;


    protected $fillable = [
        "no_prakitan",
        "kode_produk",
        "qty",
    ];

    public function produk() : BelongsTo
    {
        return $this->belongsTo(Produk::class, "kode_produk", "kode_produk");
    }
}
