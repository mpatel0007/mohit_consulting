<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('package_title')->nullable();
            $table->integer('package_price')->nullable();
            $table->string('package_num_days')->nullable();
            $table->string('package_num_listings')->nullable();
            $table->tinyInteger('package_for')->nullable();
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
        Schema::dropIfExists('package');
    }
}
