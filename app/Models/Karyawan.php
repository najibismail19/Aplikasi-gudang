<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Karyawan extends Authenticatable
{
    use HasFactory;

    protected $table = 'karyawan';
    protected $primaryKey = "nik";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = false;

    protected $guarded = [];

    public function jabatan() : BelongsTo
    {
        return $this->belongsTo(Jabatan::class, "id_jabatan", "id_jabatan");
    }

    public function gudang() : BelongsTo
    {
        return $this->belongsTo(Gudang::class, "id_gudang", "id_gudang");
    }

    public function login() : HasOne
    {
        return $this->hasOne(Login::class, "nik", "nik");
    }

    public function pembelian() : HasMany
    {
        return $this->hasMany(Pembelian::class, "nik", "nik");
    }
}
