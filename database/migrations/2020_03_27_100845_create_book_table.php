<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('BookID')->unique();
            $table->string('Name')->nullable();
            $table->string('Image')->nullable();
            $table->string('Color')->default("#ffffff");
            $table->integer('PublisherID')->default(0)->index()->nullable();
            $table->string("Year")->nullable()->default(0);
            $table->integer("CatID")->index();
            $table->text("Opt")->nullable();
            $table->integer("View")->default(0);
            $table->float("Rating")->default(0);
            $table->integer("RNumber")->default(0);

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
        Schema::dropIfExists('books');
    }
}
