<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnToCmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cms', function (Blueprint $table) {
            $table->string('metatitle')->nullable()->change();
            $table->string('metakeyword')->nullable()->change();
            $table->string('metadescription')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cms', function (Blueprint $table) {
            //
        });
    }
}
