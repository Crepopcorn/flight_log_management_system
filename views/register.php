<?php
require_once '../controllers/UserController.php';

// initialize empty message variable
$message = '';

// form submission for user registration
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userController = new UserController();
    
    // check if username already exists
    $existingUser = $userController->getUserByUsername($_POST['username']);
    if ($existingUser) {
        // if username exists, show error message
        $message = "Username already exists";
    } else {
        // if username not exist, proceed with registration
        $userController->register($_POST['username'], $_POST['password']);
        header("Location: login.php");
        exit();
    }
}
?>

<!-- HTML for registration page -->
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- information & link to styles -->
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body class="login-page">
    <div class="login-container">
        <!-- create form for user registration -->
        <form method="POST">
            <h2>Register</h2>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <?php if ($message): ?>
                <p style="color: red;"><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>
            <button type="submit">Register</button>
        </form>
        <button onclick="window.location.href='login.php';">Return to Login Page</button>
    </div>
</body>
</html>
