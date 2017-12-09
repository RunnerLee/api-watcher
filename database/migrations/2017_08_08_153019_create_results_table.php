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
            $table->integer('mission_id')->unsigned();
            $table->enum('is_successful', [
                'yes', 'no'
            ]);
            $table->enum('is_timeout', [
                'yes', 'no'
            ]);
            $table->integer('time_cost')->unsigned();
            $table->integer('status_code')->unsigned();
            $table->integer('response_size')->default(0);
            $table->text('response_headers');
            $table->text('response_content');
            $table->text('error_message');
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
