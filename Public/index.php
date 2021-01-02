<?php declare(strict_types=1);

    // requiring composer's autoloader for app dependencies
    require dirname(__DIR__). '/vendor/autoload.php';

    // loading up all env variables in the .env file into the $_ENV superglobal
    $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();

    // specifying our default error and exception handlers
    set_error_handler('Core\Error::errorHandler');
    set_exception_handler('Core\Error::exceptionHandler');

    $url = $_SERVER['QUERY_STRING'];
    $router = new Core\Router();

    // creating all api routes
    $router->add('api/v1/signup', ['resource'=>'Signup', 'method'=>'post']);

    $router->dispatch($url);
?>