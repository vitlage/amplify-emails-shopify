<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('shopify_id');
            $table->integer('shop_id')->unsigned();
            $table->integer('source_id')->unsigned()->nullable();
            $table->string('title')->nullable()->nullable();
            $table->longText('image')->nullable()->nullable();
            $table->mediumText('description')->nullable();
            $table->longtext('content')->nullable();
            $table->double('price', 16, 2)->nullable();

            $table->string('source_item_id')->nullable();
            $table->longText('meta')->nullable();
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
        Schema::dropIfExists('products');
    }
}
