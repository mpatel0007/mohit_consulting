<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('team_id')->nullable();
            $table->string('task_name')->nullable(); 
            $table->text('description')->nullable();         
            $table->string('attachments')->nullable(); 
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
        Schema::dropIfExists('team_tasks');
    }
}
