<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TranslatorToBookInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('translator_to_book_info', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('TranslatorID');
            $table->unsignedBigInteger('BookInfoID');
            $table->timestamps();
        });
        Schema::table('translator_to_book_info',function (Blueprint $table){
            $table->foreign('TranslatorID')->references('id')->on('translators')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('BookInfoID')->references('id')->on('book_info')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('translator_to_book_info', function (Blueprint $table) {
            //
        });
    }
}
