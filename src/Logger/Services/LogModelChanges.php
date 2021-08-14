<?php


namespace Escherchia\LaravelScenarioLogger\Logger\Services;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;

class LogModelChanges implements LoggerServiceInterface
{
    private $tracks = [];

    public function boot()
    {
        Event::listen(['eloquent.created:*'], function($event, $data) {
            $model = str_replace('eloquent.created: ','', $event);
            if ($this->modelShouldBeTracked($model)) {
                $track = [
                   'model' => $model,
                   'type' => 'created',
                   'data' => (isset($data[0]) && $data[0] instanceof Model)? $data[0]->getAttributes() : null
                ];
                $this->tracks[] = $track;
            }
        });
        Event::listen(['eloquent.updated:*'], function($event, $data) {
            $model = str_replace('eloquent.updated: ','', $event);
            if ($this->modelShouldBeTracked($model)) {
                $changes  = (isset($data[0]) && $data[0] instanceof Model)? $data[0]->getChanges() : [];
                $olds = [];
                foreach($changes as $key => $value) {
                    $olds[$key] = $data[0]->getOriginal($key);
                }
                $track = [
                    'model' => $model,
                    'type' => 'updated',
                    'new' => (isset($data[0]) && $data[0] instanceof Model)? $data[0]->getChanges() : null,
                    'old' => $olds
                ];
                $this->tracks[] = $track;
            }
        });
        Event::listen(['eloquent.deleted:*'], function($event, $data) {
            $model = str_replace('eloquent.deleted: ','', $event);
            if ($this->modelShouldBeTracked($model)) {
                $track = [
                    'model' => $model,
                    'type' => 'deleted',
                ];
                $this->tracks[] = $track;
            }
        });
    }

    public function report()
    {
        return $this->tracks;
    }

    private function modelShouldBeTracked($model): bool
    {
        $tobeTrackedModels = Config::get('laravel-scenario-logger.service-configuration.log-model-changes.models');

        if (in_array($model, $tobeTrackedModels)) {
            return true;
        }
        return false;
    }
}
