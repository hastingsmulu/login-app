
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
$failedAttempts = isset($_SESSION['failed_attempts']) ? $_SESSION['failed_attempts'] : 'N/A';
$lastFailedAttempt = isset($_SESSION['last_failed_attempt']) ? $_SESSION['last_failed_attempt'] : 'N/A';
$lastLoginTime = isset($_SESSION['last_login_time']) ? $_SESSION['last_login_time'] : 'N/A';
?>
<?php include 'head.php'; ?>
<?php include 'navbar.php'; ?>
<body>
   
 
    <!-- Welcome Section -->
	<br><br>
    <div class="welcome-container">
	
	 <div class="login-info-card">
	 
        <p>Welcome <br><?php echo htmlspecialchars($_SESSION['username']); ?>!
        </p>
        <h3>Login Information</h3><br>
        <p><strong>Login Attempts:</strong> <?php echo $failedAttempts; ?></p>
        <p><strong>Last Attempt:</strong> <?php echo $lastFailedAttempt ? date('Y-m-d H:i:s', strtotime($lastFailedAttempt)) : 'N/A'; ?></p>
        <p><strong>Last Login:</strong> <?php echo $lastLoginTime ; ?></p>
    </div>
        
       
        
        <!-- Graph Section -->
        <div class="graph-container">
            <canvas id="myChart"></canvas>
        </div>
    </div>
</body>
</html>
