<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('Fullname')->nullable();
            $table->string('Phone')->unique()->nullable();
            $table->string('Email')->unique()->nullable();
            $table->string('Password')->nullable();
            $table->string('DeviceID')->unique();
            $table->string('Model');

            $table->string('api_token', 80)->unique()->nullable()->default(null);
            $table->timestamp('email_verified_at')->nullable();
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
        Schema::dropIfExists('users');
    }
}
