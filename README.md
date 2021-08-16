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

2. add package service provider to app providers at `config/app.php`:
```php
    ...
       /*
        * Package Service Providers...
        */
        Escherchia\LaravelScenarioLogger\LaravelScenarioLoggerServiceProvider::class
    ...
```

3. in order to handle logging on exceptions add this lines of code to Your default exception handler(usually `App\Exception\Handler`):

```php
    use Escherchia\LaravelScenarioLogger\Logger\ScenarioLogger;
    public function register()
    {
            $this->reportable(function (Throwable $e) {
                ScenarioLogger::logForService('log-exception', $e);
                ScenarioLogger::finish();
            });
    }
        ...
```

4. App/User class must implement `ScenarioLoggerUserProviderInterface` like this:

```php
    use Escherchia\LaravelScenarioLogger\Contracts\ScenarioLoggerUserProviderInterface;

    class User extends Authenticatable implements ScenarioLoggerUserProviderInterface 
    {
        public function getId(){
            // please write proper implementation here to present user id
        }
        public function getName(){
            // please write proper implementation here to present user name
        }
    }
```

5. run publish command on your shell if your want to access package configuration file in your application:

```shell script
      php artisan vendor:publish
```

6. run migrations to ensure you have proper tables in database :

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
    'default-storage-driver' => Path\TO\YourStorageDriver,
...
```

`YourStorageDriver` class must implement `Escherchia\LaravelScenarioLogger\StorageDrivers\StorageDriverInterface`

#### database driver connection
if you decide to use built-in database driver to log your scenarios art persistent layer, you can specify
which database driver should be used.
 ```php
...
    'storage-driver-configuration' => [
        'database' => [
            'connection' => 'your-connection-name'
        ]   
    ]
...
```
 ### logger services
 
 for each scenario each part of logging is handled by a dedicated module. 
 you can remove this feature from process of scenario logger by commeting this module on list of active services:
```php
...
  'active-services' => [
         'log-model-changes',
         'log-request',
         'log-response',
         'log-exception',
         'log-manual-trace'
  ]
...
```
each service could be have its own configuration. service's specific configuration could be found like this:

```php
...
  'service-configuration' => [
          'log-model-changes' => [
              'models' => [
                  User::class
              ]
          ],
          'log-response' => [
              'disable-store-content' => true
          ]
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
- write proper tests
- update dependencies in composer.json
- structured columns for database driver
- support logger in console mode

# Suggested Features

- log viewer utility
- scenario naming ability
- disable scenario logger for some routes
- authenticated user log improvement


