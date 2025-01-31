<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Redirect to login page if not logged in
    exit();
}

require 'Database.php';
require 'User.php';

$database = new Database();
$userModel = new User($database);
$user = $userModel->getUser($_SESSION['user_id']);
?>

<?php include 'head.php'; ?>
<?php include 'navbar.php'; ?>
<body>
       <div class="container"> <!-- New container div -->
        <div class="card profile-card">
            <div class="welcome-container">
                <h1>Welcome <br>
                <?php echo htmlspecialchars($user['username']); ?>!</h1>
                <div class="profile-photo">
                    <?php if ($user['profile_image']): ?>
                        <img src="<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Profile Photo" class="rounded-photo">
                    <?php else: ?>
                        <img src="face4s.jpg" alt="Default Profile Photo" class="rounded-photo">
                    <?php endif; ?>
                </div>
                <p>Your Profile:</p>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                <a href="edit_profile.php">Edit Profile</a>
                <a href="logout.php" style="margin-top: 20px; display: inline-block; background-color: #dc3545;">Logout</a>
            </div>
        </div>
    </div>
</body>

</html>
