<?php declare(strict_types=1);

    namespace App\Resources;
    
    use Core\Resource;
    use App\Models\User;

    class Signup extends Resource {

        public function post() {
            
            $errors = $this->has();

            if(!empty($errors)) {
                http_response_code(422);
                echo json_encode($errors);
                return;
            }
        
            $this->data->name = filter_var($this->data->name, FILTER_SANITIZE_STRING);
            $this->data->email = filter_var($this->data->email, FILTER_SANITIZE_EMAIL);
            $this->data->password = filter_var($this->data->password, FILTER_SANITIZE_STRING);

            $errors = $this->validate();

            if(!empty($errors)) {
                http_response_code(422);
                echo json_encode($errors);
                return;
            }

            if(User::save($this->data->name, $this->data->email, $this->data->password)) {
                $data = $this->data;
                unset($data->password);
                http_response_code(200);
                echo json_encode($data);
                return;
            }

            throw new \Exception('failure to save new user', 500);
        }

        public function has() {
            
            $errors = [];

            if(empty($this->data->name)) {
                $errors['name'] = array('name is required');
            }
            
            if(empty($this->data->email)) {
                $errors['email'] = array('email is required');
            }

            if(empty($this->data->password)) {
                $errors['password'] = array('password is required');
            }

            return $errors;
        }

        public function validate() {
            
            $errors = [];
            $names = explode(' ', $this->data->name, 2);

            if(count($names) < 2) {
                $errors['name'] = array('first and last names are required');
            }

            if(!filter_var($this->data->email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = array($this->data->email.' is not a valid email address');
            }

            if(strlen($this->data->password) < 8) {
                $errors['password'] = array('password must be at least 8 characters');
            }

            return $errors;
        }
    }

?>