<?
$password = 'your_password';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert the new user into the database
$stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
$stmt->execute(['username' => 'your_username', 'password' => $hashedPassword]);

?>