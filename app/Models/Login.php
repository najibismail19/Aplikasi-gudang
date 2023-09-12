<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Login extends Model
{
    use HasFactory;

    protected $table = 'login';
    protected $primaryKey = "id";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'tanggal_login',
        'nik',
        'tanggal_logout',
        'ip',
        'device'
    ];

    public function karyawan() : BelongsTo
    {
        return $this->belongsTo(Karyawan::class, "nik", "nik");
    }

    public function scopeFilter($query, array $filter)
    {
        $query->when($filter["search"] ?? false, function ($query, $search) {
            return $query->where('device', 'like', '%' . $search . '%')
                        ->orWhere('ip', 'like', '%' . $search . '%');
        });
    }


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        });
    }

    public function getKeyType()
    {
        return 'string';
    }
}
