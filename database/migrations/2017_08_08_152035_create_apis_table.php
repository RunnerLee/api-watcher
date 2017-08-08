<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id');
            $table->string('url', 2083);
            $table->string('name');
            $table->enum('method', [
                'POST',
                'GET',
                'PUT',
                'PATCH',
                'OPTIONS',
                'HEAD',
                'DELETE',
            ]);
            $table->tinyInteger('timeout')->unsigned();
            $table->text('headers');
            $table->text('options');
            $table->text('rules');
            $table->tinyInteger('except_status')->unsigned()->default(200);
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
        Schema::table('apis', function (Blueprint $table) {
            $table->drop();
        });
    }
}
