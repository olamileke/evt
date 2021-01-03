<?php declare(strict_types=1);

    namespace App\Resources;

    use App\Resources\AuthenticatedResource;

    class Events extends AuthenticatedResource {

        public function post() {
            echo $this->params['userID'];
        }
    } 


?>