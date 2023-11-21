<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserSubMenu extends Model
{
    use HasFactory;

    protected $table = 'user_sub_menu';
    protected $primaryKey = "sub_menu_id";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = true;

    protected $guarded = [];

    public function menu() : BelongsTo
    {
        return $this->belongsTo(UserMenu::class, "menu_id", "menu_id");
    }

    public function userAccessMenu() : HasMany
    {
        return $this->hasMany(userAccessMenu::class, "user_menu_id", "user_menu_id");
    }
}
