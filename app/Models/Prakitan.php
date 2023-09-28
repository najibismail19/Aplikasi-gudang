<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Prakitan extends Model
{
    use HasFactory;

    protected $table = "prakitan";
    protected $primaryKey = "no_prakitan";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = false;

    protected $guarded = [];


    public function scopeFilter($query, array $filter)
    {
        $query->when($filter["awal"] ?? false, function ($query, $tanggal_awal) {
            $query->when($filter["akhir"] ?? false, function ($query, $tanggal_akhir) use ($tanggal_awal) {
                return $query->whereBetween('tanggal_actual_prakitan', [$tanggal_awal, $tanggal_awal]);
            });
        });
    }

    public function detailPrakitan() : BelongsToMany
    {
       return $this->belongsToMany(Produk::class, "detail_prakitan", "no_prakitan", "kode_produk")
       ->using(DetailPrakitan::class);
    }

    public function karyawan() : BelongsTo
    {
        return $this->belongsTo(Karyawan::class, "nik", "nik");
    }

    public function produk() : BelongsTo
    {
        return $this->belongsTo(Produk::class, "kode_produk", "kode_produk");
    }
}
