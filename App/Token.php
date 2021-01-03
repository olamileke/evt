<?php

    namespace App;

    // token helper class to generate random tokens that will be used for completing signup
    class Token {

        private $token;

        public function __construct($token = null) {
            $this->$token = $token ?? bin2hex(openssl_random_pseudo_bytes(16));
        }

        public function retrieveToken() {
            return $this->token;
        }

        public function hashToken() {
            $secretKey = $_ENV['SECRET_KEY'];
            return hash_hmac('sha256', $this->token, $secretKey);
        }
    }

?>