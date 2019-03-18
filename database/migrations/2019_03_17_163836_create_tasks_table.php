<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            // $table->integer('owner_id')->unsigned();
            $table->text('description');
            $table->date('start');
            $table->date('finish');
            // $table->foreign('owner_id')
                //   ->references('id')
                //   ->on('users')
                //   ->onDelete('cascade');
            $table->integer('goal_id')->unsigned();
            $table->foreign('goal_id')
                  ->references('id')
                  ->on('goal')
                  ->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
