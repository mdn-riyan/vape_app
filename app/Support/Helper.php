<?php
namespace App\Support;

use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Helper
{
    public static function menus()
    {
        $roleIds = DB::table('role_users')
            ->where('user_id', Auth::id())
            ->pluck('role_id');

        $menuIds = DB::table('role_menus')
            ->whereIn('role_id', $roleIds)
            ->pluck('menu_id');

        $all = Menu::whereIn('id', $menuIds)
            ->orderBy('urut')
            ->get();

        $children = $all->where('parent', '>', 0)->groupBy('parent');

        return $all->where('parent', 0)
            ->filter(fn ($m) => $m->url !== '#' || $children->has($m->id))
            ->each(fn ($m) => $m->setRelation('children', $children->get($m->id, collect())))
            ->values();
    }

    public static function activeMenu($menus)
    {
        foreach ($menus as $menu) {
            if (request()->is(ltrim($menu->url, '/') . '*') && $menu->url !== '#') {
                return ['parent' => null, 'menu' => $menu];
            }

            foreach ($menu->children as $child) {
                if (request()->is(ltrim($child->url, '/') . '*')) {
                    return ['parent' => $menu, 'menu' => $child];
                }
            }
        }

        return ['parent' => null, 'menu' => null];
    }
}

?>
