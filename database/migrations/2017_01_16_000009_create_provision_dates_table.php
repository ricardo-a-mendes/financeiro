<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvisionDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if (!Schema::hasTable('provision_dates')) {
			Schema::create('provision_dates', function (Blueprint $table) {
				$table->increments('id');
				$table->unsignedInteger('provision_id');
				$table->foreign('provision_id')->references('id')->on('provisions');
                $table->unsignedInteger('account_id');
                $table->foreign('account_id')->references('id')->on('accounts');
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
        Schema::dropIfExists('provision_dates');
    }
}
