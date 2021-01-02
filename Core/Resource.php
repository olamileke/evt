<?php 

    namespace Core;

    class Resource {

        protected $params;

        public function __construct(array $params) {
            $this->params = $params; 
        }

        public function __call($method, $args) {
            
            if(method_exists($this, $method)) {
                call_user_func_array([$this, $method], $args);
            }
        }
    }

?>