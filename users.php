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

// Access Control
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

require_once 'include.db.php';

try { // B-14
    $stmt = $mysqli->prepare("SELECT id, firstname, lastname, email, username FROM users");
    $stmt->execute();
    $result = $stmt->get_result();
    $users = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} catch (Exception $e) {
    die("An error occurred while fetching users.");
}
?>

<h1>Registered Users</h1>
<ul>
    <?php foreach ($users as $user): ?>
        <li>
            ID: <?php echo htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8'); ?> |
            Username: <?php echo htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8'); ?> |
            Name: <?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname'], ENT_QUOTES, 'UTF-8'); ?> |
            Email: <?php echo htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8'); ?>
        </li>
    <?php endforeach; ?>
</ul>

<p><a href="admin.php">Back to Dashboard</a></p>
<p><a href="logout.php">Logout</a></p>