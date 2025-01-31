<?php
session_start();

require 'Database.php';
require 'User.php';

// Set the maximum allowed login attempts
$max_attempts = 3;
// Lockout duration in seconds (30 minutes)
$lockout_duration = 30 * 60;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $userModel = new User($database);

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Initialize failed login attempts and lockout time if not already set
    if (!isset($_SESSION['failed_attempts'])) {
        $_SESSION['failed_attempts'] = 0;
    }

    if (!isset($_SESSION['lockout_time'])) {
        $_SESSION['lockout_time'] = null;
    }

    // Check if the user is currently locked out
    if ($_SESSION['failed_attempts'] >= $max_attempts) {
        $time_since_lockout = time() - $_SESSION['lockout_time'];

        // If lockout period has passed, reset failed attempts and lockout time
        if ($time_since_lockout > $lockout_duration) {
            $_SESSION['failed_attempts'] = 0;
            $_SESSION['lockout_time'] = null;
        } else {
            // Display countdown timer and prevent further login attempts
            $remaining_time = $lockout_duration - $time_since_lockout;
            header("Location: lockout.php?time_remaining=$remaining_time");
            exit();
        }
    }

    // Attempt login
    $user = $userModel->login($username, $password);

    if ($user) {
        // Reset failed attempts after successful login
        $_SESSION['failed_attempts'] = 0;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
		$_SESSION['failed_attempts'] = $user['failed_attempts'];
        header('Location: Welcome.php'); // Redirect to the welcome page
        exit();
    } else {
        // Increment failed login attempts
        $_SESSION['failed_attempts']++;

        // If maximum attempts exceeded, set lockout time
        if ($_SESSION['failed_attempts'] >= $max_attempts) {
            $_SESSION['lockout_time'] = time(); // Record the time of lockout
        }

        // Set error message and redirect back to login page
        $_SESSION['error_message'] = "Invalid username or password.";
        header('Location: index.php'); // Redirect back to the login page
        exit();
    }
}
?>
