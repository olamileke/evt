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
            // making sure that the event to be retrieved exists and belongs to 
            // the user making the request
            if(!$event) {
                throw new \Exception('event does not exist', 404);
                return;
            }

            $data = ['data' => ['event' => $event]];
            http_response_code(200);
            echo json_encode($data);
        }

        public function put() {

            $id = (int)$this->params['id'];
            $userID = (int)$this->params['userID'];

            $event = \App\Models\Event::findByID($id, $userID);
            // making sure that the event to be edited exists and belongs to the
            // the user making the request
            if(!$event) {
                throw new \Exception('event does not exist', 404);
                return;
            }

            $errors = $this->has();
            
            if(!empty($errors)) {
                echo json_encode($errors);
                return;
            }

            $this->data->name = filter_var($this->data->name, FILTER_SANITIZE_STRING);
            $this->data->description = filter_var($this->data->description, FILTER_SANITIZE_STRING);

            $errors = $this->validate();

            if(!empty($errors)) {
                echo json_encode($errors);
                return;
            }

            $event = \App\Models\Event::update($id, $this->data->name, $this->data->description, $userID);
            $data = ['data' => ['event' => $event]];
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