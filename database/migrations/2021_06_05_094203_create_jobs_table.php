<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_id')->nullable();
            $table->string('jobtitle')->nullable();
            $table->string('jobdescription')->nullable();
            $table->string('jobskill_id')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->string('is_freelance')->nullable();
            $table->string('careerlevel')->nullable();
            $table->string('salaryfrom')->nullable();
            $table->string('salaryto')->nullable();
            $table->string('salaryperiod')->nullable();
            $table->string('hidesalary')->nullable();
            $table->integer('functional_id')->nullable()->comment('functional_id = subcategories id');
            $table->string('jobtype')->nullable();
            $table->string('jobshift')->nullable();
            $table->integer('positions')->nullable();
            $table->string('gender')->nullable();
            $table->date('jobexprirydate')->nullable();
            $table->integer('degreelevel_id')->nullable();
            $table->string('experience')->nullable();
            $table->tinyInteger('status')->nullable();
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
        Schema::dropIfExists('jobs');
    }
}
