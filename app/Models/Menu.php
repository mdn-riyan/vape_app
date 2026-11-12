<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Menu extends Model
{
    protected $fillable = ['nama_menu','url','icon','parent','urut'];

    public function roles()
        {
            return $this->belongsToMany(Role::Class, 'role_menus', 'menu_id', 'role_id');
        }


}
