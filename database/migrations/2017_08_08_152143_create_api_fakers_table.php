<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiFakersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fakers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('api_id')->unsigned();
            $table->text('variables');
            $table->text('queries');
            $table->text('requests');
            $table->text('headers');
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
        Schema::table('fakers', function (Blueprint $table) {
            $table->drop();
        });
    }
}
