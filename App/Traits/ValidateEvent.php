<?php declare(strict_types=1);

    namespace App\Traits;

    trait ValidateEvent {
        
        // checking if the various required params are present in the request
        public function has() {

            $errors = [];

            if(empty($this->data->name)) {
                $errors['name'] = array('name is required');
            }

            if(empty($this->data->description)) {
                $errors['description'] = array('description is required');
            }

            return $errors;
        }

        public function validate() {

            $errors = [];

            if(strlen($this->data->name) < 3) {
                $errors['name'] = array($this->data->name.' is not up to 3 characters');
            }

            if(strlen($this->data->description) < 10) {
                $errors['description'] = array($this->data->description.' is not up to 10 characters');
            }

            return $errors;
        }
    }



?>