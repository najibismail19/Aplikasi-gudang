<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAccessMenu extends Model
{
    use HasFactory;

    protected $table = 'user_access_menu';
    protected $primaryKey = "sub_menu_id";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = true;

    protected $guarded = [];

    public function subMenu() : BelongsTo
    {
        return $this->belongsTo(UserMenu::class, "sub_menu_id", "sub_menu_id");
    }
}
