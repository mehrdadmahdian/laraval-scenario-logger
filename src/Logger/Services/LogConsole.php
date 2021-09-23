<?php

namespace Escherchia\LaravelScenarioLogger\Logger\Services;

use Illuminate\Console\Events\CommandFinished;
use Illuminate\Console\Events\CommandStarting;
use Illuminate\Support\Facades\Auth;
use Psy\Command\Command;

class LogConsole implements LoggerServiceInterface
{
    /**
     * @var CommandStarting
     */
    private $commandStartedObject;

    /**
     * @var CommandFinished
     */
    private $commandFinishedObject;
    /**
     *
     */
    public function boot(): void
    {
    }

    /**
     * @return array
     */
    public function report(): array
    {
        if (isset( $this->commandStartedObject)) {
            return [
                'command' => $this->commandStartedObject ?  $this->commandStartedObject->command : null,
                'options' => $this->commandStartedObject ? $this->commandStartedObject->input->getOptions() : null,
                'arguments' => $this->commandStartedObject ? $this->commandStartedObject->input->getArguments(): null
            ];
        }
        return [];
    }

    /**
     * @param mixed $data
     */
    public function log($data): void
    {
        if ($data instanceof CommandStarting) {
            $this->commandStartedObject = $data;
        }

        if ($data instanceof CommandFinished) {
            $this->commandFinishedObject = $data;
        }
    }
}
