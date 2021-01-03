<?php declare(strict_types=1);

    namespace App\Models;

    use PDO;

    class Event extends \Core\Model {

        public static function save(int $userID, string $name, string $description) {
            
            $db = self::getDB();
            $sql = "INSERT INTO events(user_id, name, description, created_at) VALUES(:user_id, :name, :description, :created_at)";
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':user_id', $userID, PDO::PARAM_INT);
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->bindValue(':description', $description, PDO::PARAM_STR);
            $stmt->bindValue(':created_at', time(), PDO::PARAM_INT);
            $stmt->execute();

            return self::retrieveLatestEvent($userID);
        }

        public static function retrieveLatestEvent(int $userID) {

            $db = self::getDB();
            $sql ='SELECT * FROM events WHERE user_id=:user_id ORDER BY id DESC LIMIT 1';
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':user_id', $userID, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
            $stmt->execute();

            return $stmt->fetch();
        }
    }

?>