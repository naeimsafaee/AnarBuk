<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_info', function (Blueprint $table) {
            $table->id();
            $table->text("Images")->nullable();
            $table->integer("Price");
            $table->string("Edition")->nullable();
            $table->integer("CustomerID")->nullable()->index();
            $table->unsignedBigInteger("BookID");
            $table->string("format")->nullable();
//            $table->boolean("Status")->default(0);
            $table->timestamps();
        });

        Schema::table('book_info', function (Blueprint $table) {
            $table->foreign('BookID')->references('id')
                ->on('books')->onDelete('cascade')
                ->onUpdate('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_info');
    }
}
