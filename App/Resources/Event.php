<?php declare(strict_types=1);

    namespace App\Resources;

    use App\Resources\AuthenticatedResource;
    use App\Traits\ValidateEvent;

    class Event extends AuthenticatedResource {
        
        use ValidateEvent;

        public function get() {

            $id = (int)$this->params['id'];
            $userID = (int)$this->params['userID'];

            $event = \App\Models\Event::findByID($id, $userID);

            if(!$event) {
                throw new \Exception('event does not exist', 404);
                return;
            }

            $data = ['data' => ['event' => $event]];
            http_response_code(200);
            echo json_encode($data);
        }

        public function delete() {
             
            
            $id = (int)$this->params['id'];
            $userID = (int)$this->params['userID'];

            $event = \App\Models\Event::findByID($id, $userID);

            if(!$event) {
                throw new \Exception('event does not exist', 404);
                return;
            }

            \App\Models\Event::delete($id);
            http_response_code(200);
            echo json_encode(['message' => 'event deleted successfully']);
        }
    }

?>