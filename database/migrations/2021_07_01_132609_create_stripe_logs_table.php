<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStripeLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stripe_logs', function (Blueprint $table) {  
            $table->bigIncrements('id');     
            $table->longText('logs')->nullable();
            //$table->string('functional_area_id')->nullable();          
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
        Schema::table('stripe_logs', function (Blueprint $table) {
            //
        });
    }
}
