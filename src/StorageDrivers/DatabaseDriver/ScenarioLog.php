<?php

namespace Escherchia\LaravelScenarioLogger\StorageDrivers\DatabaseDriver;

use Illuminate\Database\Eloquent\Model;

class ScenarioLog extends Model
{
    /**
     * @var string[]
     */
    public $guarded = ['id'];
    /**
     * @var string[]
     */
    public $casts = ['raw_log' => 'array'];
}
