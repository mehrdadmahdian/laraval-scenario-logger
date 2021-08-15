<?php

namespace Escherchia\LaravelScenarioLogger\Logger\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Events\TransactionBeginning;
use Illuminate\Database\Events\TransactionCommitted;
use Illuminate\Database\Events\TransactionRolledBack;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;

class LogModelChanges implements LoggerServiceInterface
{
    private $tracks = [];

    private $currentTransactionUniqueCode = null;
    private $transactionStatus = [];

    /**
     *
     */
    public function boot(): void
    {
        $this->currentTransactionUniqueCode = microtime();

        Event::listen(['eloquent.created:*'], function ($event, $data) {
            $model = str_replace('eloquent.created: ', '', $event);
            if ($this->modelShouldBeTracked($model)) {
                $track = [
                   'model' => $model,
                   'type' => 'created',
                   'data' => (isset($data[0]) && $data[0] instanceof Model)? $data[0]->getAttributes() : null,
                ];
                $this->tracks[$this->currentTransactionUniqueCode][] = $track;
            }
        });
        Event::listen(['eloquent.updated:*'], function ($event, $data) {
            $model = str_replace('eloquent.updated: ', '', $event);
            if ($this->modelShouldBeTracked($model)) {
                $changes  = (isset($data[0]) && $data[0] instanceof Model)? $data[0]->getChanges() : [];
                $olds = [];
                foreach ($changes as $key => $value) {
                    $olds[$key] = $data[0]->getOriginal($key);
                }
                $track = [
                    'model' => $model,
                    'type' => 'updated',
                    'new' => (isset($data[0]) && $data[0] instanceof Model)? $data[0]->getChanges() : null,
                    'old' => $olds,
                ];
                $this->tracks[$this->currentTransactionUniqueCode][] = $track;
            }
        });
        Event::listen(['eloquent.deleted:*'], function ($event, $data) {
            $model = str_replace('eloquent.deleted: ', '', $event);
            if ($this->modelShouldBeTracked($model)) {
                $track = [
                    'model' => $model,
                    'type' => 'deleted',
                ];
                $this->tracks[$this->currentTransactionUniqueCode][] = $track;
            }
        });
        Event::listen([TransactionBeginning::class], function ($event) {
            $this->currentTransactionUniqueCode = microtime();
        });
        Event::listen([TransactionCommitted::class], function ($event) {
            $this->transactionStatus[$this->currentTransactionUniqueCode] = 'commited';
            $this->currentTransactionUniqueCode = microtime();
        });
        Event::listen([TransactionRolledBack::class], function ($event) {
            $this->transactionStatus[$this->currentTransactionUniqueCode] = 'rollbacked';
            $this->currentTransactionUniqueCode = microtime();
        });
    }

    /**
     * @return array
     */
    public function report(): array
    {
        $data =  [
          'transaction_status' => $this->transactionStatus,
          'changes' => $this->tracks,
        ];
        foreach ($data as $key => $datum) {
            if (is_null($datum) or (is_array($datum) and count($datum) == 0)) {
                unset($data[$key]);
            }
        }

        return $data;
    }

    /**
     * @param $model
     * @return bool
     */
    private function modelShouldBeTracked($model): bool
    {
        $tobeTrackedModels = Config::get('laravel-scenario-logger.service-configuration.log-model-changes.models');

        if (in_array($model, $tobeTrackedModels)) {
            return true;
        }

        return false;
    }

    /**
     * @param mixed ...$data
     */
    public function log($data): void
    {
        // TODO: Implement log() method.
    }
}
