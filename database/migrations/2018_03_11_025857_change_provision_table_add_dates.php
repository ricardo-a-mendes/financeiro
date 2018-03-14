<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeProvisionTableAddDates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('provisions')) {
            Schema::table('provisions', function (Blueprint $table) {
                $table->date('start_at')->after('value');
                $table->date('valid_until')->after('start_at');
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
        if (Schema::hasTable('provisions')) {
            Schema::table('provisions', function (Blueprint $table) {
                $table->removeColumn('start_at');
                $table->removeColumn('valid_until');
            });
        }
    }
}
