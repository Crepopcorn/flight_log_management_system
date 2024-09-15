<?php

// Get Heroku ClearDB connection information

$servername = "servername";// fill in server name at here
$username = "username";// fill in username at here
$password = "password";// fill in password at here
$dbname = "database name";// fill in database name at here

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>


