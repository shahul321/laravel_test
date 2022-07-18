<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model {

    public function items() {
        return $this->hasMany(MenuItem::class, 'parent_id');
    }

   
    public function childItems() {
        return $this->hasMany(MenuItem::class, 'parent_id')->with('items');
    }

}
