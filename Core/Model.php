<?php declare(strict_types=1);

    namespace Core;

    use PDO;

    abstract class Model {

        public static function getDB() {

            $dbHost = $_ENV['DB_HOST'];
            $dbName = $_ENV['DB_NAME'];
            $dbUsername = $_ENV['DB_USERNAME'];
            $dbPassword = $_ENV['DB_PASSWORD'];
            $conn = null;

            if(!$conn) {

                // creating a PDO object that will be used for database operations
                try { 
                    $conn = new PDO("mysql:host=".$dbHost.";dbname=".$dbName.";charset=utf8", $dbUsername, $dbPassword);
                    // setting up the PDO object to report errors
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    return $conn;
                }
                catch(PDOException $e) {
                    throw new \Exception($e->getMessage(), 500);
                }
            }

            return $conn;
        }
    }



?>