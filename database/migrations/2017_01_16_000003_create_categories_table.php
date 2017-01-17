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
				$table->unsignedInteger('user_id');
				$table->foreign('user_id')->references('id')->on('users');
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
