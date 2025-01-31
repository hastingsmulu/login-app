<?php
session_start();

require 'Database.php';
require 'User.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $userModel = new User($database);

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Attempt to register the user
    if ($userModel->register($username, $password)) {
        echo "Registration successful! You can now <a href='index.html'>login</a>.";
    } else {
        echo "Username already taken. Please choose another.";
    }
}
?>
