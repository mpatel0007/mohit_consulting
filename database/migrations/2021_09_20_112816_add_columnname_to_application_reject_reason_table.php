<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnnameToApplicationRejectReasonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_reject_reason', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('application_reject_subject');
            $table->string('application_reject_description');
            $table->integer('job_id');
            $table->integer('candidate_id');
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
        Schema::dropIfExists('application_reject_reason');

    }
}
