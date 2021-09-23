<?php

namespace Escherchia\LaravelScenarioLogger\Controllers;

use Illuminate\Routing\Controller;

class LaravelScenarioLoggerController extends Controller
{

    public function index()
    {
        dd('here at index');
    }

    public function show(string $id)
    {
        dd('here at show');
    }



}