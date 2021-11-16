<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppliedjobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appliedjobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('job_id')->nullable();
            $table->integer('candidate_id')->nullable();
            $table->integer('status')->default('2')->comment('0 = rejected , 1 = accepted , 2 = processing');
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
        Schema::dropIfExists('appliedjobs');
    }
}
