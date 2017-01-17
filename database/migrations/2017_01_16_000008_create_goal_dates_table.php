<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoalDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if (!Schema::hasTable('goal_dates')) {
			Schema::create('goal_dates', function (Blueprint $table) {
				$table->increments('id');
				$table->unsignedInteger('goal_id');
				$table->foreign('goal_id')->references('id')->on('goals');
				$table->unsignedInteger('user_id');
				$table->foreign('user_id')->references('id')->on('users');
				$table->timestamp('target_date');
				$table->timestamps();
			});
		}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goal_dates');
    }
}
