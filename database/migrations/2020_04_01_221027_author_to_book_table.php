<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AuthorToBookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('author_to_book', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('AuthorID');
            $table->unsignedBigInteger('BookID');
            $table->timestamps();
        });
        Schema::table('author_to_book',function (Blueprint $table){
            $table->foreign('AuthorID')->references('id')->on('authors')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::table('author_to_book', function (Blueprint $table) {
            //
        });
    }
}
