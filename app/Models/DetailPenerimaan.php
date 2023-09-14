<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DetailPenerimaan extends Pivot
{
    use HasFactory;

    protected $table = "detail_penerimaan";
    protected $foreignKey = "no_penerimaan";
    protected $reletedKey = "kode_produk";
    public $timestamps = false;

    protected $fillable = [
        "no_penerimaan",
        "kode_produk",
        "jumlah",
    ];

    public function produk() : BelongsTo
    {
        return $this->belongsTo(Produk::class, "kode_produk", "kode_produk");
    }

}
