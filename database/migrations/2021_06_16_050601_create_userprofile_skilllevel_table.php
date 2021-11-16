<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserprofileSkilllevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userprofile_skilllevel', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('userprofile_id')->nullable();
            $table->integer('skill_id')->nullable();          
            $table->integer('level_id')->nullable();          
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('userprofile_skilllevel');
    }
}
