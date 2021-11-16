<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsadminToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('profileimg')->nullable();
            $table->string('fname')->nullable();
            $table->string('mname')->nullable();
            $table->string('lname')->nullable();
            $table->string('fathername')->nullable();
            $table->date('dateofbirth')->nullable();
            $table->enum('gender', ['male','female','other']);
            $table->string('maritalstatus')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('experience')->nullable();
            $table->string('careerlevel')->nullable();
            $table->integer('industry_id')->nullable();
            $table->integer('functional_id')->nullable();
            $table->string('currentsalary')->nullable();
            $table->string('expectedsalary')->nullable();
            $table->string('streetaddress')->nullable();
            $table->tinyInteger('is_admin')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
