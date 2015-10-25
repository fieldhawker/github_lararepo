<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_key',128)->index();
            $table->string('week')->index();
            $table->text('station');
            $table->text('place');
            $table->text('work');
            $table->text('language');
            $table->text('report');
            $table->text('sales');
            $table->timestamps();
            $table->string('updated_by');
            //$table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('reports');
    }
}
