<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('api_id')->unsigned();
            $table->integer('faker_id')->unsigned();
            $table->enum('is_successful', [
                'yes', 'no'
            ]);
            $table->enum('is_timeout', [
                'yes', 'no'
            ]);
            $table->tinyInteger('time_cost');
            $table->tinyInteger('status_code');
            $table->integer('response_size')->default(0);
            $table->text('response_headers');
            $table->text('response_content');
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
        Schema::table('results', function (Blueprint $table) {
            $table->drop();
        });
    }
}
