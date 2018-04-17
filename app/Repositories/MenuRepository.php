<?php

namespace App\Repositories;

use App\Models\Menu;

class MenuRepository
{
    public function allMenu()
    {
        return Menu::OrderBy('orderBy')->all();
    }

    public function listMenu()
    {
        return Menu::OrderBy('orderBy')->paginate(20);
    }


    /**
     * @param String $menu_name
     * @return \App\Menu
     */
    public function byName($menu_name){
        return Menu::where('contain',$menu_name)->firstOrFail();
    }

    /**
     * @param Int $menu_id
     * @return \App\Menu
     */
    public function byId($menu_id){
        return Menu::where('id',$menu_id)->firstOrFail();
    }
}