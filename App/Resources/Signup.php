<?php declare(strict_types=1);

    namespace App\Resources;
    
    use Core\Resource;

    class Signup extends Resource {

        public function post() {
            http_response_code(200);
            echo json_encode('leke');
        }
    }

?>