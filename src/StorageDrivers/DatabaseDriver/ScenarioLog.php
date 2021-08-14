<?php

namespace Escherchia\LaravelScenarioLogger\StorageDrivers\DatabaseDriver;

use Illuminate\Database\Eloquent\Model;

class ScenarioLog extends Model
{
    public $guarded = ['id'];
    public $casts = ['raw_log' => 'array'];
}
