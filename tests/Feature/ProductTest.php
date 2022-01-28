<?php

namespace Tests\Feature;

use App\Categories;
use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_product__belongs_to_category(){
        $category = factory(Categories::class)->create();
        $product = factory(Product::class)->create(['category_id'=>$category->id]);
        $this->assertInstanceOf(Categories::class,$product->category);
    }

    public function test_a_product__belongs_to_created_by(){
        $user = factory(User::class)->create(['name'=>'Administrador']);
        $product = factory(Product::class)->create(['created_by'=>$user->id]);
        $this->assertInstanceOf(User::class,$product->createdBy);
    }
}
