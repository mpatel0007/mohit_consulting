<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Companies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('companylogo')->nullable();
            $table->string('companyname')->nullable();
            $table->string('companyemail')->nullable();
            $table->string('password')->nullable();
            $table->string('companyseo')->nullable();
            $table->integer('industry_id')->nullable()->comment('industry_id = categories id');
            $table->string('ownershiptype')->nullable();
            $table->longText('companydetail')->nullable();
            $table->string('location')->nullable();
            $table->string('googlemap')->nullable();
            $table->string('numberofoffices')->nullable();
            $table->string('website')->nullable();
            $table->string('numberofemployees')->nullable();
            $table->string('establishedin')->nullable();
            $table->string('fax')->nullable();
            $table->string('phone')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('google')->nullable();
            $table->string('pinterest')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('package_id')->nullable();
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
        //
    }
}
