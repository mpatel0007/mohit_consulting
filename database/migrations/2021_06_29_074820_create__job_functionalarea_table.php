<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobFunctionalareaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Job_functionalarea', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('job_id')->nullable();
            $table->integer('functional_area_id')->nullable()->comment('functional_area_id = subcategories id');          
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
        Schema::dropIfExists('Job_functionalarea');
    }
}
