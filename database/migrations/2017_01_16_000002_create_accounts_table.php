<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if (!Schema::hasTable('accounts')) {
			Schema::create('accounts', function (Blueprint $table) {
				$table->increments('id');
				$table->unsignedInteger('account_type_id');
				$table->foreign('account_type_id')->references('id')->on('account_types');
				$table->string('name', 145);
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
        Schema::dropIfExists('accounts');
    }
}
