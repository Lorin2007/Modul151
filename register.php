<?php
// Session setup
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();

require_once 'include.db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = trim($_POST['firstname'] ?? '');
    $lastname = trim($_POST['lastname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($firstname) || empty($lastname) || empty($email) || empty($username) || empty($password)) {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email address.';
    } else {
        try {
            // Check if username already exists
            $stmt = $mysqli->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $error = 'Username is already taken.';
            }
            $stmt->close();

            if (empty($error)) {
                // Hash password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT); // B-9

                // Insert user - B-13
                $stmt = $mysqli->prepare("INSERT INTO users (firstname, lastname, email, username, password) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $firstname, $lastname, $email, $username, $hashed_password);
                $stmt->execute();
                $stmt->close();
                $success = 'Registration successful! You can now log in.';
            }
        } catch (Exception $e) {
            $error = 'An error occurred during registration. Please try again.';
        }
    }
}
?>

<?php if ($error !== ''): ?>
    <div>Error: <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
<?php endif; ?>

<?php if ($success !== ''): ?>
    <div>Success: <?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></div>
<?php endif; ?>

<form action="register.php" method="POST">
    <label for="firstname">First Name:</label>
    <input type="text" name="firstname" id="firstname" required><br>
    
    <label for="lastname">Last Name:</label>
    <input type="text" name="lastname" id="lastname" required><br>
    
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required><br>
    
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required><br>
    
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required><br>
    
    <button type="submit">Register</button>
</form>

<a href="login.php">Login here</a>