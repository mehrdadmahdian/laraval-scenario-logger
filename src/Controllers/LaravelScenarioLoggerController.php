<?php

namespace Escherchia\LaravelScenarioLogger\Controllers;

use Escherchia\LaravelScenarioLogger\StorageDrivers\DatabaseDriver\DatabaseDriver;
use Escherchia\LaravelScenarioLogger\StorageDrivers\DatabaseDriver\ScenarioLog;
use Illuminate\Routing\Controller;
use Yajra\DataTables\Facades\DataTables;

class LaravelScenarioLoggerController extends Controller
{
    /**
     * Displays datatables front end view
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('lsl::index');

    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data()
    {
        $query = ScenarioLog::query();

        return Datatables::of($query)
            ->editColumn('type', function($row){
                $raw_log = $row->raw_log;
                return isset($raw_log['services']['log_console']) ? 'Console' : 'Http Request';
            })
            ->editColumn('action', function($row) {
                $raw_log = $row->raw_log;
                if (isset($raw_log['services']['log_console'])) {
                    return isset($raw_log['services']['log_console']['command']) ? $raw_log['services']['log_console']['command'] : '';
                } else {
                    return isset($raw_log['services']['log_request']['url']) ? $raw_log['services']['log_request']['url'] : '';
                }
            })
            ->editColumn('name', function($row) {
                return '';
            })
            ->make(true);
    }



}
