<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('title');
            $table->text('summary');
            $table->text('description');
            $table->string('media_id');
            $table->string('code');
            $table->integer('inventory');
            $table->integer('price');
            $table->integer('productcat_id')->unsigned();
            $table->timestamps();
        });
        Schema::table('products', function($table) {
            $table->foreign('productcat_id')->references('id')->on('productcats');
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
