<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penerimaan extends Model
{
    use HasFactory;

    protected $table = "penerimaan";
    protected $primaryKey = "no_penerimaan";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = false;

    protected $guarded = [];

    public function scopeFilter($query, array $filter)
    {
        $query->when($filter["awal"] ?? false, function ($query) use ($filter) {
            $query->when($filter["akhir"] ?? false, function ($query) use ($filter) {
                return $query->whereBetween('tanggal_penerimaan', [$filter["awal"], $filter["akhir"]]);
            });
        });
    }

    public function karyawan() : BelongsTo
    {
        return $this->belongsTo(Karyawan::class, "nik", "nik");
    }

    public function pembelian() : BelongsTo
    {
        return $this->belongsTo(Pembelian::class, "no_pembelian", "no_pembelian");
    }
}
