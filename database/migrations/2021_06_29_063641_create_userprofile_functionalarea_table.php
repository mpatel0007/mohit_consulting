<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserprofileFunctionalareaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userprofile_functionalarea', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('userprofile_id')->nullable();
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
        Schema::dropIfExists('userprofile_functionalarea');
    }
}
