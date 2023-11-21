<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserMenu extends Model
{
    use HasFactory;
    
    protected $table = 'user_menu';
    protected $primaryKey = "menu_id";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = true;

    protected $guarded = [];

    public function subMenu() : HasMany
    {
        return $this->hasMany(subMenu::class, "menu_id", "menu_id");
    }

}
