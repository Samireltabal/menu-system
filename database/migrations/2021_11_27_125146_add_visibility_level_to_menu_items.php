<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVisibilityLevelToMenuItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->string('visibility_level')->default('all');
            $table->integer('order')->unsigned()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropColumn('visibility_level');
            $table->dropColumn('order');
        });
    }
}
