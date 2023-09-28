<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = "kode_produk";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = false;

    protected $guarded = [];


    public function scopeFilter($query, array $filter)
    {
        $query->when($filter["jenis_produk"] ?? false, function ($query, $jenis) {
            if($jenis == "P-J") {
                return $query->where("produk.jenis", true);
            }
            if($jenis == "P-M") {
                return $query->where("produk.jenis", false);
            }

        });
    }


    public function detailPembelian() : BelongsToMany
    {
       return $this->belongsToMany(Pembelian::class, "detail_pembelian", "kode_produk", "no_pembelian")
       ->using(DetailPembelian::class);;
    }

    public function detailPrakitan() : BelongsToMany
    {
       return $this->belongsToMany(Prakitan::class, "detail_prakitan", "kode_produk", "no_prakitan")
       ->using(DetailPrakitan::class);;
    }

    public function masterPrakitanProdukMentah() : HasMany
    {
        return $this->hasMany(MasterPrakitan::class, "kode_produk_mentah", "kode_produk");

    }

    public function masterPrakitanProdukJadi() : HasMany
    {
        return $this->hasMany(MasterPrakitan::class, "kode_produk_jadi", "kode_produk");
    }

    public function prakitan() : HasMany
    {
        return $this->hasMany(Prakitan::class, "kode_produk", "kode_produk");
    }
}
