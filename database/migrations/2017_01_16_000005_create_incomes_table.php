<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if (!Schema::hasTable('incomes')) {
			Schema::create('incomes', function (Blueprint $table) {
				$table->increments('id');
				$table->unsignedInteger('account_id');
				$table->foreign('account_id')->references('id')->on('accounts');
				$table->decimal('values', 14, 2);
				$table->unsignedSmallInteger('status')->default(1);
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
        Schema::dropIfExists('incomes');
    }
}
