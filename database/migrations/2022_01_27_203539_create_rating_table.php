<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $user = factory(\App\User::class)->create();
        $product = factory(\App\Product::class)->create();
        Schema::create('rating', function (Blueprint $table) use($user,$product){
            $table->id();
            $table->float('score');
            $table->morphs('rateable');
            $table->morphs('qualifier');
            /*$table->unsignedBigInteger('user_id')->default($user->id);
            $table->unsignedBigInteger('product_id')->default($product->id);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('product_id')->references('id')->on('products');*/
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rating');
    }
}
