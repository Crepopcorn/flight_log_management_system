<?php
require_once '../models/User.php';

// usercontroller class for handling user operations
class UserController {
    private $user;

    public function __construct() {
        $this->user = new User();
    }

    // user login with username & password
    public function login($username, $password) {
        $user = $this->user->findByUsername($username);
        if ($user && password_verify($password, $user['password'])) {
            // start session & set user id if session not yet started
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['user_id'] = $user['id'];
            header("Location: ../views/manage_flight_logs.php");
            exit();
        } else {
            return "Incorrect username or password!";
        }
    }

    // user registration
    public function register($username, $password) {
        return $this->user->create($username, $password);
    }

    // check if username exist in database or not
    public function getUserByUsername($username) {
        return $this->user->findByUsername($username); // Use the existing findByUsername method in User model
    }

    // reset user password
    public function resetPassword($username, $newPassword) {
        return $this->user->updatePassword($username, $newPassword);
    }

    // delete user account & destroy session
    public function deleteAccount($userId) {
        if ($this->user->delete($userId)) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            session_unset();
            session_destroy();
            header("Location: ../views/login.php");
            exit();
        } else {
            return "Failed to delete account. Please try again.";
        }
    }

    // logout user by destroying session
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        header("Location: ../views/login.php");
        exit();
    }

    // check if a user is authenticated & redirect if not
    public function isAuthenticated() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header("Location: ../views/login.php");
            exit();
        }
    }
}

// logout action if requested
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    $userController = new UserController();
    $userController->logout();
}
?>
