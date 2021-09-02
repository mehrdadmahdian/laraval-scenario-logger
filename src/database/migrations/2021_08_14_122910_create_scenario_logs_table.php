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
     * @return voidd
     */
    public function up()
    {
        if (
            Config::has('laravel-scenario-logger.storage-driver-configuration.database.connection') &&
            Config::get('laravel-scenario-logger.storage-driver-configuration.database.connection') !== null) {
            $connectionName = Config::get('laravel-scenario-logger.storage-driver-configuration.database.connection');
        } else {
            $connectionName = DB::getDefaultConnection();
        }
        Schema::connection($connectionName)->create(lsl_db_pfx() . 'scenario_logs', function (Blueprint $table) {
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
        Schema::drop(lsl_db_pfx() . 'scenario_logs');
    }
}
