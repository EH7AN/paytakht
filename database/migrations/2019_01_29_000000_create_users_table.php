<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('family')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('mobile')->unique();
            $table->string('postal_code')->nullable();
            $table->string('national_code')->nullable();
            $table->boolean('is_active')->default(false);
            $table->text('address')->nullable();
            $table->string('password');
            $table->integer('role_id')->unsigned();
            $table->integer('media_id')->unsigned()->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        Schema::table('users', function($table) {
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('media_id')->references('id')->on('media');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
