<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $guarded = [];

    public function products(){
        return $this->hasMany(\App\Product::class);
    }
}
