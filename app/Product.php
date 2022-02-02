<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Utils\CanBeRated;
use \App\Categories;
use \App\User;

class Product extends Model
{
    use CanBeRated;
    //Variable de campos protegidos
    protected $guarded = [];

    public function category(){
        return $this->belongsTo(Categories::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class,'created_by');
    }

    protected static function booted()
    {
        /*static::created(function(Product $product){
            $faker = \Faker\Factory::create();
            $product->image_path = $faker->imageUrl();
            $product->createdBy()->associate(auth()->user()->name,1);
        });*/
    }
}
