<?php
// Session setup
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start(); // B-5

require_once 'include.db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Both username and password are required.';
    } else {
        try {
            $stmt = $mysqli->prepare("SELECT id, password FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result($id, $hashed_password);
            if ($stmt->fetch()) {
                if (password_verify($password, $hashed_password)) { // B-10
                    // Successful login
                    session_regenerate_id(true); // B-8
                    $_SESSION['loggedin'] = true;
                    $_SESSION['user_id'] = $id;
                    $_SESSION['username'] = $username;
                    
                    header("Location: admin.php");
                    exit;
                } else {
                    $error = 'Invalid username or password.';
                }
            } else {
                $error = 'Invalid username or password.';
            }
            $stmt->close();
        } catch (Exception $e) {
            $error = 'An error occurred. Please try again.';
        }
    }
}
?>

<?php if ($error !== ''): ?>
    <div>Error: <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
<?php endif; ?>

<form action="login.php" method="POST">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required><br>
    
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required><br>
    
    <button type="submit">Login</button>
</form>

<a href="register.php">Register here</a>