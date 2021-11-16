<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSubscriptionCharges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_charges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('charge_id')->nullable();       
            $table->string('subscription_id')->nullable();     
            $table->longText('data')->nullable();
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
        Schema::table('subscription_charges', function (Blueprint $table) {
            //
        });
    }
}
