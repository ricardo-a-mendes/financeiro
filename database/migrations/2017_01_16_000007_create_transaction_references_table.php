<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if (!Schema::hasTable('transaction_references')) {
			Schema::create('transaction_references', function (Blueprint $table) {
				$table->increments('id');
				$table->string('description');
                $table->unsignedInteger('account_id');
                $table->foreign('account_id')->references('id')->on('accounts');
				$table->unsignedInteger('user_id');
				$table->foreign('user_id')->references('id')->on('users');
				$table->unsignedInteger('category_id')->default(0);
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
        Schema::dropIfExists('transaction_references');
    }
}
