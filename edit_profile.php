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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password']; // Optional field

    // Handle profile image upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_image']['tmp_name'];
        $fileName = $_FILES['profile_image']['name'];
        $fileSize = $_FILES['profile_image']['size'];
        $fileType = $_FILES['profile_image']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Only allow specific file types
        $allowedfileExtensions = ['jpg', 'gif', 'png', 'jpeg'];
        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Set a new filename and upload path
            $newFileName = 'profile_' . $_SESSION['user_id'] . '.' . $fileExtension;
            $uploadFileDir = './';
            $dest_path = $uploadFileDir . $newFileName;

            // Move the file to the uploads directory
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $userModel->updateProfileImage($_SESSION['user_id'], $dest_path);
            } else {
                $error_message = "Error moving the uploaded file.";
            }
        } else {
            $error_message = "Only JPG, GIF, PNG, and JPEG files are allowed.";
        }
    }

    // Update username and password
    if ($userModel->updateUser($_SESSION['user_id'], $username, $password)) {
        $_SESSION['success_message'] = "Profile updated successfully!";
        header('Location: profile.php'); // Redirect to profile page
        exit();
    } else {
        $error_message = "Failed to update profile.";
    }
}
?>
<?php include 'head.php'; ?>
<?php include 'navbar.php'; ?>
<body>
     <div class="container"> <!-- New container div -->
        <div class="card profile-card">
            <div class="welcome-container">
                <div class="edit-container">
        <h1>Edit Profile</h1>
       <form action="edit_profile.php" method="POST" enctype="multipart/form-data">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br>
    <label for="password">Password (leave blank to keep current):</label>
    <input type="password" id="password" name="password"><br>
    <label for="profile_image">Profile Picture:</label>
    <input type="file" id="profile_image" name="profile_image" accept="image/*">
    <button type="submit" class="success">Update</button>
</form>

        <div class="error">
            <?php
            if (isset($error_message)) {
                echo htmlspecialchars($error_message);
            }
            ?>
        </div>
        <?php
        if (isset($_SESSION['success_message'])) {
            echo '<div class="success">' . htmlspecialchars($_SESSION['success_message']) . '</div>';
            unset($_SESSION['success_message']); // Clear the message after displaying it
        }
        ?>
    </div>
            </div>
        </div>
    </div>
</body>

