<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $fillable = ['nama_role'];

    public function users()
        {
            return $this->belongsToMany(User::class, 'role_users', 'role_id', 'user_id');
        }

    public function menus()
        {
            return $this->belongsToMany(Menu::class, 'role_menus', 'role_id', 'menu_id');
        }

}
