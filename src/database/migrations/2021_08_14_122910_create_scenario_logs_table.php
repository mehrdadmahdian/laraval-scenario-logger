<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateScenarioLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( $connectionName = config('laravel-scenario-logger.driver.database.connection', null) );
        else {
            $connectionName = DB::getDefaultConnection();
        }
        Schema::connection($connectionName)->create('scenario_logs', function (Blueprint $table) {
            $table->id();
            $table->text('raw_log')->nullable();
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
        Schema::drop('scenario_logs');
    }
}
