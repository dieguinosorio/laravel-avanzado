<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryIdToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $category = new \App\Categories();
        $category->name = 'Otros';
        $category->inactive = 0;
        $category->save();
        Schema::table('products', function (Blueprint $table) use ($category){
            $table->unsignedBigInteger('category_id')->default($category->id);
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });
    }
}
