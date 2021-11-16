<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableStripeLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stripe_logs', function (Blueprint $table) {
            $table->string('message')->nullable();       
            $table->integer('user_id')->nullable();       
            $table->tinyInteger('is_candidate')->nullable();       
        });      
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stripe_logs', function (Blueprint $table) {
            //
        });
    }
}
