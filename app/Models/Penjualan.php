<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = "penjualan";
    protected $primaryKey = "no_penjualan";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = false;

    protected $guarded = [];

    public function karyawan() : BelongsTo
    {
        return $this->belongsTo(Karyawan::class, "nik", "nik");
    }

    public function customer() : BelongsTo
    {
        return $this->belongsTo(Customer::class, "id_customer", "id_customer");
    }

    public function detailPenjualan() : BelongsToMany
    {
       return $this->belongsToMany(Produk::class, "detail_penjualan", "no_penjualan", "kode_produk")
       ->using(DetailPenjualan::class);
    }
}
