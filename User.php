<?php
class User {
    private $db;
    private $max_attempts = 3;        // Max allowed login attempts
    private $lockout_duration = 1800; // 30 minutes in seconds

    public function __construct(Database $database) {
        $this->db = $database->getConnection();
    }

    public function login($username, $password) {
        // Check if the user exists
        $stmt = $this->db->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user) {
            // Check if the account is locked
            if ($user['failed_attempts'] >= $this->max_attempts) {
                $lockout_time_remaining = time() - strtotime($user['last_attempt_time']);
                if ($lockout_time_remaining < $this->lockout_duration) {
                    // User is still locked out
                    return ['error' => 'Account locked. Please wait ' . (($this->lockout_duration - $lockout_time_remaining) / 60) . ' minutes before retrying.'];
                } else {
                    // Lockout duration has passed, reset failed attempts
                    $this->resetFailedAttempts($user['id']);
                }
            }

            // Verify password
            if (password_verify($password, $user['password'])) {
                // Reset failed attempts and update last login time on successful login
                $this->resetFailedAttempts($user['id']);
                $this->updateLastLoginTime($user['id']);
				
				$_SESSION['failed_attempts'] = ($user['failed_attempts']);
                $_SESSION['last_failed_attempt'] = null; // Clear previous attempts
                $_SESSION['last_login_time'] = date('Y-m-d H:i:s');
                return $user; // Login successful
            } else {
                // Password is incorrect, increment failed attempts
                $this->incrementFailedAttempts($user['id']);
				  $_SESSION['failed_attempts'] = $user['failed_attempts'] + 1;
                $_SESSION['last_failed_attempt'] = date('Y-m-d H:i:s');
                return false; // Incorrect login
            }
        }

        return false; // User not found
    }

    public function register($username, $password) {
        // Check if the username already exists
        $stmt = $this->db->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->execute(['username' => $username]);
        if ($stmt->fetch()) {
            return false; // Username already taken
        }

        // Hash the password and insert the new user
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare('INSERT INTO users (username, password) VALUES (:username, :password)');
        return $stmt->execute(['username' => $username, 'password' => $hashedPassword]);
    }

    public function getUser($userId) {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->execute(['id' => $userId]);
        return $stmt->fetch();
    }

    public function updateUser($userId, $username, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare('UPDATE users SET username = :username, password = :password WHERE id = :id');
        return $stmt->execute(['username' => $username, 'password' => $hashedPassword, 'id' => $userId]);
    }

    public function updateProfileImage($userId, $imagePath) {
        $stmt = $this->db->prepare('UPDATE users SET profile_image = :profile_image WHERE id = :id');
        return $stmt->execute(['profile_image' => $imagePath, 'id' => $userId]);
    }

    private function incrementFailedAttempts($userId) {
        $stmt = $this->db->prepare('UPDATE users SET failed_attempts = failed_attempts + 1, last_attempt_time = NOW() WHERE id = :id');
        $stmt->execute(['id' => $userId]);
    }

    private function resetFailedAttempts($userId) {
        $stmt = $this->db->prepare('UPDATE users SET failed_attempts = 0 WHERE id = :id');
        $stmt->execute(['id' => $userId]);
    }

    private function updateLastLoginTime($userId) {
        $stmt = $this->db->prepare('UPDATE users SET last_login_time = NOW() WHERE id = :id');
        $stmt->execute(['id' => $userId]);
    }
}
