<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnToJobSkillLevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_skill_level', function (Blueprint $table) {
            
            $table->integer('job_id')->nullable();
            $table->integer('skill_id')->nullable();          
            $table->integer('level_id')->nullable();          
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_skill_level', function (Blueprint $table) {
            //
        });
    }
}
