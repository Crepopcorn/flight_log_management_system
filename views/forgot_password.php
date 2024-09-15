<?php
require_once '../controllers/UserController.php';

// initialize empty message variable
$message = '';

// form submission for password reset
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userController = new UserController();
    
    // check whether username exists before reset password
    $user = $userController->getUserByUsername($_POST['username']);
    if ($user) {
        // if user exists, reset password
        $userController->resetPassword($_POST['username'], $_POST['new_password']);
        header("Location: login.php");
        exit();
    } else {
        // if user not exist, show error message
        $message = "Username not exists";
    }
}
?>

<!-- HTML for forgot password page -->
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- information & link to styles -->
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body class="login-page">
    <div class="login-container">
        <!-- create form for password reset -->
        <form method="POST">
            <h2>Reset Password</h2>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="new_password" placeholder="New Password" required>
            
            <?php if ($message): ?>
                <p style="color: red; text-align: center;"><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>
            
            <button type="submit">Reset Password</button>
        </form>
        <button onclick="window.location.href='login.php';">Return to Login Page</button>
    </div>
</body>
</html>
