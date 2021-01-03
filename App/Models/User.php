<?php declare(strict_types=1);

    namespace App\Models;

    use PDO;
    use App\Token;

    class User extends \Core\Model {

        public static function save(string $name, string $email, string $password) {

            // setting the correct timezone for php's datetime operations
            date_default_timezone_set('Africa/Lagos');

            $tokenObject = new Token();
            $token = $tokenObject->retrieveToken();
            $hashedToken = $tokenObject->hashToken();
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $db = self::getDB();
            $sql = "INSERT INTO users(name, email, password, activation_token, created_at) VALUES(:name, :email, :password, :token, :created_at)";
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
            $stmt->bindValue(':token', $hashedToken, PDO::PARAM_STR);
            $stmt->bindValue(':created_at', time() , PDO::PARAM_INT);
            $stmt->execute();

            return self::retrieveLatestUser();
        }

        public static function authenticate(string $email, string $password) {

            $user = self::findByEmail($email);

            if(!$user) {
                return;
            }

            if(password_verify($password, $user->password)) {
                return $user;
            }

            return;
        }

        public static function findByEmail($email) {

            $db = self::getDB();
            $sql = "SELECT * FROM users WHERE email=:email";
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
            $stmt->execute();

            return $stmt->fetch();
        }

        public static function retrieveLatestUser() {
            
            $db = self::getDB();
            $sql = 'SELECT * FROM users ORDER BY id DESC LIMIT 1';
            $stmt = $db->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
            $stmt->execute();

            return $stmt->fetch();
        }
    }


?>