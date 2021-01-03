<?php declare(strict_types=1);

    namespace Core;

    class Error {

        public static function errorHandler($level, $message, $file, $line) {
            throw new \ErrorException($message, 500, $level, $file, $line);
        }

        public static function exceptionHandler($e) {

            $code = $e->getCode() ?? 500;
            $message = ['message' => $e->getMessage(), 'file'=> $e->getFile(), 'line' => $e->getLine()];
            http_response_code((int)$code);
            echo json_encode($message);
        }
    }

?>