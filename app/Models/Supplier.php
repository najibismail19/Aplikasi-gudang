<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier';
    protected $primaryKey = "id_supplier";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = false;

    protected $guarded = [];


    public function pembelian() : HasMany
    {
        return $this->hasMany(Pembelian::class, "id_supplier", "id_supplier");
    }
}
