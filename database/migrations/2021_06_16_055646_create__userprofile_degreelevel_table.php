<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserprofileDegreelevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userprofile_degreelevel', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('userprofile_id')->nullable();
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
        Schema::dropIfExists('userprofile_degreelevel');
    }
}
