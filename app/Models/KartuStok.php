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

    public function scopeFilter($query, array $filter)
    {
        $query->when($filter["awal"] ?? false, function ($query, $tanggal_awal) {
            $query->when($filter["akhir"] ?? false, function ($query, $tanggal_akhir) use ($tanggal_awal) {
                return $query->whereBetween('tanggal', [$tanggal_awal, $tanggal_awal]);
            });
        });

        $query->when(($filter["gudang"]) ?? false, function ($query, $gudang){
            return $query->where('id_gudang', $gudang);
        });

        $query->when(($filter["no_referensi"]) ?? false, function ($query, $no_referensi){
            return $query->where('no_referensi', $no_referensi);
        });

        $query->when(($filter["kode_produk"]) ?? false, function ($query, $kode_produk){
            return $query->where('kode_produk', $kode_produk);
        });
    }

    public function produk() : BelongsTo
    {
        return $this->belongsTo(Produk::class, "kode_produk", "kode_produk");
    }

    public function gudang() : BelongsTo
    {
        return $this->belongsTo(Gudang::class, "id_gudang", "id_gudang");
    }
}
