<?php declare(strict_types=1);

    namespace App\Resources;

    use Core\Resource;
    use Firebase\JWT\JWT;

    class AuthenticatedResource extends Resource {
        
        public function authGuard() {

            $headers = getallheaders();

            // if there is no auth header set, the request is not allowed to proceed
            if(!array_key_exists('Authorization', $headers)) {
                http_response_code(401);
                echo json_encode(['message' => 'missing authentication token']);
                return;
            }

            $authorizationHeader = (string)$headers['Authorization'];

            // checking if the auth header exists but is not in the correct Bearer X format
            $token = explode(' ', $authorizationHeader)[1];

            if(!$token) {
                http_response_code(401);
                echo json_encode(['message' => 'missing authentication token']);
                return;
            }

            // checking for the validity of the jwt token
            try {
                $secretKey = $_ENV['SECRET_KEY'];
                $decodedToken = JWT::decode($token, $secretKey, array('HS256'));
                $this->params['userID'] = $decodedToken->userID;
            }
            catch(Exception $e) {
                throw new \Exception($e->getMessage(), 401);
            }
        }
    }


?>