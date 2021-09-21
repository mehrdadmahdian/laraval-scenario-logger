<p align="center">
  <h3 align="center">Laravel Scenario Logger</h3>

  <p align="center">
    This Package helps you in laravel application to log all desired activity for each request from request entry point to generate response at a single snapshot. 
  </p>
</p>



<!-- TABLE OF CONTENTS -->
<details open="open">
  <summary>Table of Contents</summary>
  <ol>
    <li><a href="#installation">Installation</a></li>
    <li><a href="#usage">Usage</a></li>
    <li><a href="#contact">Contact</a></li>
    <li><a href="#acknowledgements">Acknowledgements</a></li>
    <li><a href="#contributing">Contributing</a></li>
    <li><a href="#todo">Todo List</a></li>
    <li><a href="#Suggested Features">Suggested Feature</a></li>
  </ol>
</details>

# Installation

1. run composer command
```shell script
    composer require escherchia/laravel-scenario-logger
```

2. In order to handle logging on exceptions add this lines of code to Your default exception handler(usually `App\Exception\Handler`):

```php
    use Escherchia\LaravelScenarioLogger\Logger\ScenarioLogger;
    public function register()
    {
            $this->reportable(function (Throwable $e) {
                ScenarioLogger::logForService('log_exception', $e);
                ScenarioLogger::finish();
            });
    }
        ...
```

3. run publish command on your shell if your want to access package configuration file in your application:

```shell script
      php artisan vendor:publish
```

4. run migrations to ensure you have proper tables in database :

```shell script
      php artisan migrate
```


please select `LaravelScenarioLoggerServiceProvider` in order to publish package providers



<!-- USAGE EXAMPLES -->
# Usage

  After proper installation of this package into your application, all request will
   be logged using default storage driver which is `database` built-in storage driver. 
   Default storage driver is defined in package configuration file.
   
   in order to log scenarios, logger service must be active. this feature could be find on 
   configuration file:
```php
...
   'is_active' => true,
...
```
   
 ### storage 
 alternative logging storage driver could be defined by defining 
 that in configuration file like this:
 
 ```php
...
    'default_storage_driver' => Path\TO\YourStorageDriver,
...
```

`YourStorageDriver` class must implement `Escherchia\LaravelScenarioLogger\StorageDrivers\StorageDriverInterface`

#### database driver connection
if you decide to use built-in database driver to log your scenarios art persistent layer, you can specify
which database driver should be used.
 ```php
...
    'storage_drivers' => [
        'database' => [
            'connection' => 'your-connection-name'
        ]   
    ]
...
```
 ### logger services
 
 for each scenario each part of logging is handled by a dedicated module. 
 you can remove this feature from process of scenario logger by commenting this module on list of active services:
```php
...
  'service_configuration' => [
     'log_user' => [
        'active' => true,
        'class' => LogUser::class
    ],
    'log_response' => [
        'active' => true,
        'class' => LogResponse::class,
        'disable-store-content' => false,
    ],
    'log_request' => [
        'active' => true,
        'class' => LogRequest::class,
    ],
    'log_exception' => [
        'active' => true,
        'class' => LogException::class,
    ],
    'log_manual_trace' => [
        'active' => true,
        'class' => LogManualTrace::class,
    ],
    'log_model_changes' => [
        'active' => true,
        'class' => LogModelChanges::class,
        'models' => [
            // model goes here
        ],
    ],
  ]
...
```

### excluded routes
you can introduce some route uris as excluded routes to log like this:
```php
...
  'excluded-routes' => [
     'some/route/uri'
  ]
...
```

<!-- CONTRIBUTING -->
# Contributing

if you want to contribute in this project please follow this instruction.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a PR on this repository
6. wait to accept and merge the PR

<!-- LICENSE -->
# License

Distributed under the MIT License. See `LICENSE` for more information.

<!-- CONTACT -->
# Contact

Mehrdad Mahdian: [Gmail](mahdian.mhd@gmail.com)

Project Link: [laraval-scenario-logger](https://github.com/escherchia/laraval-scenario-logger)


# Todo
- descriptive comment for config items
- update dependencies to proper versions in composer.json
- support logger in console mode

# Suggested Features

- log viewer utility
- console commands scenario logs
- ability to store logs in queue


