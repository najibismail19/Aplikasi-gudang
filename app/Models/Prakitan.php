<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function detailPrakitan() : BelongsToMany
    {
       return $this->belongsToMany(Produk::class, "detail_prakitan", "no_prakitan", "kode_produk")
       ->using(DetailPrakitan::class);
    }
}
