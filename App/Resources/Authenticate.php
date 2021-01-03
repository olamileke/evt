<?php declare(strict_types=1);

    namespace App\Resources;

    use Firebase\JWT\JWT;
    use Core\Resource;
    use App\Models\User;

    class Authenticate extends Resource {

        public function post() {

            $errors = $this->has();

            if(!empty($errors)) {
                http_response_code(422);
                echo json_encode($errors);
                return;
            }

            $this->data->email = filter_var($this->data->email, FILTER_SANITIZE_EMAIL);
            $this->data->password = filter_var($this->data->password, FILTER_SANITIZE_STRING);
            $errors = $this->validate();

            if(!empty($errors)) {
                http_response_code(422);
                echo json_encode($errors);
                return;
            }

            $user = User::authenticate($this->data->email, $this->data->password);

            if(!$user) {
                throw new \Exception('incorrect username or password', 404);
                return;
            }

            if($user->activation_token) {
                throw new \Exception('incorrect username or password', 404);
                return;
            }

            $secretKey = $_ENV['SECRET_KEY'];
            $now = time();
            $params = ['userId' => $user->id];
            $params['iat'] = $now;
            $params['nbf'] = $now;
            $params['exp'] = $now;
            $jwtToken = JWT::encode($params, $secretKey);
            $user = ['name' => $user->name, 'email' => $user->email, 'created_at' => $user->created_at];
            $data = ['user' => $user, 'token' => $jwtToken];
            echo json_encode($data);
        }

        // checking if the various required params are present in the request
        public function has() {

            $errors = [];

            if(empty($this->data->email)) {
                $errors['email'] = array('email is required');
            }

            if(empty($this->data->password)) {
                $errors['password'] = array('password is required');
            }

            return $errors;
        }

        // checking if request params are in the proper format
        public function validate() {

            $errors = [];

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