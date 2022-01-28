<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Categories;
use Faker\Generator as Faker;

$factory->define(Categories::class, function (Faker $faker) {
    return [
        'name'=>$faker->name,
        'inactive'=>$faker->numberBetween(0,1)
    ];
});
