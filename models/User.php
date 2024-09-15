<?php
require_once '../config/db.php';

// define user class
class User {
    private $conn;

    public function __construct() {
        global $conn; // Use global connection object
        $this->conn = $conn;
    }

    // find user using username
    public function findByUsername($username) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // create new user & password
    public function create($username, $password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        return $stmt->execute();
    }

    // update password based on username
    public function updatePassword($username, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $stmt = $this->conn->prepare("UPDATE users SET password = :password WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        return $stmt->execute();
    }

    // delete user account based on user id
    public function delete($userId) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = :userId");
        $stmt->bindParam(':userId', $userId);
        return $stmt->execute();
    }
}
?>
