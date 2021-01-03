<?php 

    namespace Core;

    class Resource {

        protected $params;
        protected $data;

        public function __construct(array $params) {
            $this->params = $params; 
            $this->data = json_decode(file_get_contents('php://input')) ?? null;
            $this->authGuard();
        }

        public function __call($method, $args) {

            if(method_exists($this, $method)) {
                call_user_func_array([$this, $method], $args);
            }
        }

        // for unauthenticated routes, this method does nothing while for
        // authenticated routes, this method will be overriden to check for 
        // validity of the jwt token
        public function authGuard() {
            return true;
        }
    }

?>