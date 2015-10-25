<?php

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
            $table->string('key',128)->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->tinyInteger('role');
            $table->rememberToken();
            $table->timestamps();
            $table->string('updated_by');
            $table->index(['name', 'password']);
            $table->index(['email', 'password']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
