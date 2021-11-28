<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('text');
            $table->string('route');
            $table->string('class')->nullable();
            $table->string('icon_name')->nullable();
            $table->string('icon_family')->default('mdi');
            $table->integer('parent_id')->nullable();
            $table->unsignedBigInteger('menu_id');
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
            $table->string('type')->default('link');
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
        Schema::disableForeignKeyConstraints();
        Schema::table('menu_items', function (BluePrint $table) {
            $table->dropForeign('menu_items_menu_id_foreign');
        });
        Schema::dropIfExists('menu_items');
        Schema::enableForeignKeyConstraints();
    }
}
