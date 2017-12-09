<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('missions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('api_group_id')->unsigned();
            $table->decimal('start_time', 15, 4)->unsigned();
            $table->decimal('finish_time', 15, 4)->unsigned()->default(0);
            $table->integer('result_count')->unsigned()->default(0);
            $table->integer('unsuccessful_result_count')->unsigned()->default(0);
            $table->enum('is_solved', [
                'yes', 'no'
            ])->default('no');
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
        Schema::drop('missions');
    }
}
