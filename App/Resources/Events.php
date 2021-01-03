<?php declare(strict_types=1);

    namespace App\Resources;

    use App\Resources\AuthenticatedResource;
    use App\Traits\ValidateEvent;
    use App\Models\Event;

    class Events extends AuthenticatedResource {

        use ValidateEvent;

        public function post() {

            $errors = $this->has();

            if(!empty($errors)) {
                http_response_code(422);
                echo json_encode($errors);
                return;
            }

            $this->data->name = filter_var($this->data->name, FILTER_SANITIZE_STRING);
            $this->data->description = filter_var($this->data->description, FILTER_SANITIZE_STRING);
            $errors = $this->validate();

            if(!empty($errors)) {
                http_response_code(422);
                echo json_encode($errors);
                return;
            }

            $event = Event::save((int)$this->params['userID'], $this->data->name, $this->data->description);
            $data = ['data' => ['event' => $event]];
            http_response_code(201);
            echo json_encode($data);
        }
    } 


?>