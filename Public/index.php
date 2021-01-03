<?php declare(strict_types=1);

    // requiring composer's autoloader for app dependencies
    require dirname(__DIR__). '/vendor/autoload.php';

    // loading up all env variables in the .env file into the $_ENV superglobal
    $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();

    // specifying our default error and exception handlers
    set_error_handler('Core\Error::errorHandler');
    set_exception_handler('Core\Error::exceptionHandler');

    // adding the correct headers to enable cors
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
    
    $url = $_SERVER['QUERY_STRING'];
    $router = new Core\Router();

    // creating all api routes
    $router->add('api/v1/signup', ['resource'=>'Signup', 'method'=>'post']);
    $router->add('api/v1/authenticate', ['resource'=>'Authenticate', 'method'=>'post']);
    $router->add('api/v1/events', ['resource'=>'Events', 'method'=>'post']);
    $router->add('api/v1/events', ['resource'=>'Events', 'method'=>'get']);
    $router->add('api/v1/events/{id:[\d]+}', ['resource'=>'Event', 'method'=>'get']);
    $router->add('api/v1/events/{id:[\d]+}', ['resource'=>'Event', 'method'=>'delete']);

    $router->dispatch($url);
?>