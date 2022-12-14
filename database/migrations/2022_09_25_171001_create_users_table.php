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
            $table->bigIncrements('id');
            $table->string('username')->unique();
            $table->string('name');
            $table->string('surname');
            $table->enum('sex', array('male','female'));
            $table->date('birthdate');
            $table->string('address');
            $table->string('city');
            $table->enum('role', array('user','staff', 'admin'))->default('user');
            $table->boolean('private')->default(false);
            $table->string('friends')->default('');
            $table->string('bio')->default('');
            $table->string('password');
            $table->rememberToken();
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