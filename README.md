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
    <li>
      <a href="#about-the-project">About The Project</a>
    </li>
    <li><a href="#installation">Installation</a></li>
    <li><a href="#usage">Usage</a></li>
    <li><a href="#contact">Contact</a></li>
    <li><a href="#acknowledgements">Acknowledgements</a></li>
    <li><a href="#contributing">Contributing</a></li>
    <li><a href="#contributionTodoList">Contribution Todo List</a></li>
  </ol>
</details>

### Installation

1. run composer command
```shell script
    composer require escherchia/laravel-scenario-logger
```

2. add package service provider to app configuration file(`config/app.php`):

3. in order to handle logging on exceptions add this lines of code to Your Default Exception Handler(usually `App\Exception\Handler`):

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

4. User class must implements `ScenarioLoggerUserProviderInterface` like this.

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

5. run publish command on your shell if your want to access package configuration file in :

```shell script
      php artisan vendor:publish
```

please select `LaravelScenarioLoggerServiceProvider` in order to publish package providers



<!-- USAGE EXAMPLES -->
## Usage

Use this space to show useful examples of how a project can be used. Additional screenshots, code examples and demos work well in this space. You may also link to more resources.

_For more examples, please refer to the [Documentation](https://example.com)_



<!-- ROADMAP -->
## Roadmap

See the [open issues](https://github.com/othneildrew/Best-README-Template/issues) for a list of proposed features (and known issues).



<!-- CONTRIBUTING -->
## Contributing

if you want to contribute in this project please follow this instruction.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a PR on this repository
6. wait for me to accept and merge the PR

<!-- LICENSE -->
## License

Distributed under the MIT License. See `LICENSE` for more information.

<!-- CONTACT -->
## Contact

Mehrdad Mahdian: [Gmail](mahdian.mhd@gmail.com)

Project Link: [laraval-scenario-logger](https://github.com/escherchia/laraval-scenario-logger)


# todo:
- method PHPDocs
- descriptive comment for config items
- write proper tests
- usage instruction on readme
- update basic config file
- update dependencies
- log viewer
- structured columns for database driver
- support ion console mode

