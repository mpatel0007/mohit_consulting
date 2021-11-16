<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_address', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('candidate_id')->nullable();       
            $table->string('address')->nullable();
            $table->integer('country_id')->nullable();       
            $table->integer('state_id')->nullable();     
            $table->integer('city_id')->nullable();
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
        Schema::dropIfExists('billing_address');
    }
}
