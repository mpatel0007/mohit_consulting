<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobDegreelevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_degreelevel', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('job_id')->nullable();
            $table->integer('degreelevel_id')->nullable();          
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
        Schema::dropIfExists('job_degreelevel');
    }
}
