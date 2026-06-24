<?php
$host = '127.0.0.1';
$username = 'k_user';
$password = 'k_2024!';
$database = '151_users';

// Enable error reporting mode for mysqli to throw exceptions
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $mysqli = new mysqli($host, $username, $password, $database);
    $mysqli->set_charset('utf8mb4');
} catch (Exception $e) {
    // Avoid exposing credentials or details in output
    die('Database connection failed.');
}
?>