<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQueriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queries', function (Blueprint $table) {
            $table->id();
            $table->string("Title");
            $table->integer("SpanCount")->default(1);
            $table->integer("Limit")->default(6);
            $table->string("Where")->default(null);
            $table->string("WhereIsWhat")->default(null);
            $table->string("SortBy")->default(null);
            $table->boolean("isSortDesc")->default(false);
            $table->boolean("Status")->default(false);
            $table->string("ForWhere");
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
        Schema::dropIfExists('queries');
    }
}
