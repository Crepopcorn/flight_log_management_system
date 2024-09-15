<?php
require_once '../controllers/UserController.php';
session_start();

// redirect logged-in user to flight logs management page
if (isset($_SESSION['user_id'])) {
    header("Location: manage_flight_logs.php");
    exit();
}

// login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userController = new UserController();
    $message = $userController->login($_POST['username'], $_POST['password']);
}
?>

<!-- HTML for the login page -->
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- information & link to styles -->
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body class="login-page">
    <div class="login-container">
        <!-- create form for user login -->
        <form method="POST">
            <h2>Login</h2>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <?php if (isset($message)) echo "<p style='color: red;'>$message</p>"; ?>
            <a href="register.php">Create New Account</a> | <a href="forgot_password.php">Forgot Password?</a>
        </form>
    </div>
</body>
</html>
