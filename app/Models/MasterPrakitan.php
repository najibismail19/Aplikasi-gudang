<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class MasterPrakitan extends Pivot
{
    use HasFactory;

    protected $table = "master_prakitan";
    protected $foreignKey = "kode_produk_jadi";
    protected $reletedKey = "kode_produk_mentah";
    public $timestamps = false;


    protected $guarded = [];

    public function produk_jadi() : BelongsTo
    {
        return $this->belongsTo(Produk::class, "kode_produk_jadi", "kode_produk");
    }

    public function produk_mentah() : BelongsTo
    {
        return $this->belongsTo(Produk::class, "kode_produk_mentah", "kode_produk");
    }

}
