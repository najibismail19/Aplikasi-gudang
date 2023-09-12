<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = "kode_produk";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = false;

    protected $guarded = [];

    public function detailPembelian() : BelongsToMany
    {
       return $this->belongsToMany(Pembelian::class, "detail_pembelian", "kode_produk", "no_pembelian")
       ->using(DetailPembelian::class);;
    }
}
