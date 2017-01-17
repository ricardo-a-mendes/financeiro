<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if (!Schema::hasTable('transactions')) {
			Schema::create('transactions', function (Blueprint $table) {
				$table->increments('id');
				$table->unsignedInteger('account_id');
				$table->foreign('account_id')->references('id')->on('accounts');
				$table->unsignedInteger('category_id');
				$table->foreign('category_id')->references('id')->on('categories');
				$table->unsignedInteger('transaction_type_id');
				$table->foreign('transaction_type_id')->references('id')->on('transaction_types');
				$table->unsignedInteger('user_id');
				$table->foreign('user_id')->references('id')->on('users');
				$table->string('description');
				$table->decimal('value', 14, 2);
				$table->timestamp('transaction_date');
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
        Schema::dropIfExists('transactions');
    }
}
