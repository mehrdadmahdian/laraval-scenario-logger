<?php

namespace Escherchia\LaravelScenarioLogger\Logger\Services;

use Illuminate\Support\Facades\Auth;

class LogUser implements LoggerServiceInterface
{
    private $user;
        //$this->user = Auth::check() ? Auth::user() : null;

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
        if ($this->user) {
            return [
                'user_id' => $this->user
            ];
        } else {
            return [];
        }
        
    }

    /**
     * @param mixed $data
     */
    public function log($data): void
    {
        $this->user = $data;
    }
}
