<?php declare(strict_types=1);

    namespace Core;

    class Router {

        protected $routes;
        protected $params;

        public function add(string $route, array $params = []) {
            
            $route = preg_replace('/\//','\\/',$route);
			$route = preg_replace('/\{([a-z-]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
			$route = '/^'.$route.'$/';
            $this->routes[$route] = $params;
        }

        public function match(string $url) {
            
            foreach($this->routes as $route => $params) {

                if(preg_match($route, $url, $matches)) {
                    
                    $this->params = $params;

                    // if there is something like an id parameter in the route
                    if($matches) {
                        foreach($matches as $key => $value) {
                            $this->params[$key] = $value;
                        }
                    }

                    return true;
                }
            }

            return false;
       }

       public function dispatch(string $url) {
            
            if($this->match($url)) {
                
                $resource = ucfirst(strtolower($this->params['resource']));
                $resource = 'App\Resources\\'.$resource;

                if(class_exists($resource)) {
                    
                    $resourceObject = new $resource($this->params);
                    $method = $this->params['method'];
                    $method = strtolower($method);

                    // checking if the resource method (POST/GET/PUT) can be called
                    if(is_callable([$resourceObject, $method])) {
                        return $resourceObject->$method();
                    }
                    
                    throw new \Exception('resource method does not exist', 404);
                }

                throw new \Exception('resource does not exist', 404);
            }
            
            throw new \Exception('endpoint does not exist', 404);
       }

    }

?>