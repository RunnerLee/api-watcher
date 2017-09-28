<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsJsonBodyToApisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apis', function (Blueprint $table) {
            $table->enum('is_json_body', [
                'yes', 'no'
            ])->default('no');
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
            $table->dropColumn('is_json_body');
        });
    }
}
