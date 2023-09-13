<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Stok extends Pivot
{
    use HasFactory;

    protected $table = "stok";
    protected $foreignKey = "id_gudang";
    protected $reletedKey = "kode_produk";
    public $timestamps = false;

    protected $guarded = [];
}
