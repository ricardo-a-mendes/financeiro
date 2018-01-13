<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if (!Schema::hasTable('categories')) {
			Schema::create('categories', function (Blueprint $table) {
				$table->increments('id');
                $table->unsignedInteger('account_id');
                $table->foreign('account_id')->references('id')->on('accounts');
				$table->string('name');
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
        Schema::dropIfExists('categories');
    }
}
