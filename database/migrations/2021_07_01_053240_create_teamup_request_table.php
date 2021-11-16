<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamupRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teamup_request', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('team_id')->nullable();
            $table->string('candidate_id')->nullable();
            $table->string('status')->nullable()->comment('0 = deny , 1 = accept , 2 = requested');
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
        Schema::dropIfExists('teamup_request');
    }
}
