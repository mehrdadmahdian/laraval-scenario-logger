<?php

namespace Escherchia\LaravelScenarioLogger\StorageDrivers\DatabaseDriver;

use Escherchia\LaravelScenarioLogger\StorageDrivers\StorageDriverInterface;

class DatabaseDriver implements StorageDriverInterface
{
    /**
     * @param array $data
     * @return bool
     */
    public function store(array $data): bool
    {
        $generic_info = $data;
        unset($generic_info['services']);

        $structured = [
            'raw_log' => $data,
            'generic_info' => $generic_info,
            'log_model_changes' => isset($data['services']['log-mnodel-changes']) ? $data['services']['log-mnodel-changes'] : null,
            'log_request' => isset($data['services']['log-request']) ? $data['services']['log-request'] : null,
            'log_response' => isset($data['services']['log-response']) ? $data['services']['log-response'] : null,
            'log_exception' => isset($data['services']['log-exception']) ? $data['services']['log-exception'] : null,
            'log_manual_trace' => isset($data['services']['log-manual-trace']) ? $data['services']['log-manual-trace'] : null,
        ];
        ScenarioLog::create($structured);

        return true;
    }
}
