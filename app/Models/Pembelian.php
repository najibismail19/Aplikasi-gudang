<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = "pembelian";
    protected $primaryKey = "no_pembelian";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = false;

    protected $guarded = [];

    public function scopeFilter($query, array $filter)
    {
        $query->when($filter["status_pembelian"] ?? false, function ($query, $search) {
            return $query->where('status_pembelian', true)->where("status_penerimaan", false);
        });
    }

    public function karyawan() : BelongsTo
    {
        return $this->belongsTo(Karyawan::class, "nik", "nik");
    }

    public function supplier() : BelongsTo
    {
        return $this->belongsTo(Supplier::class, "id_supplier", "id_supplier");
    }

    public function detailPembelian() : BelongsToMany
    {
       return $this->belongsToMany(Produk::class, "detail_pembelian", "no_pembelian", "kode_produk")
       ->using(DetailPembelian::class);
    }
}
