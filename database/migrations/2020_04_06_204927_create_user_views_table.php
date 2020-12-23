<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_views', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("BookID");
            $table->unsignedBigInteger("UserID");
            $table->timestamps();
        });

        Schema::table('user_views',function (Blueprint $table){
            $table->foreign('UserID')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('BookID')->references('id')->on('books')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_views');
    }
}
