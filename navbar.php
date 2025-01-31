 <!-- Navbar with both dropdowns on the right -->
    <div class="navbar">
        <div class="logo">
		<h4>PinΞGo <br></h4></div>
        <div class="right">
            <!-- Message dropdown -->
            <div class="envelope" onclick="toggleMessagesDropdown()">
                <img src="https://img.icons8.com/material-outlined/24/ffffff/mail.png" alt="Envelope Icon">
                <!-- Dropdown content -->
                <div class="dropdown-messages" id="messagesDropdown">
                    <a href="#">Inbox</a>
                    <a href="#">Archive</a>
                    <a href="#">Spam</a>
                    <a href="#">Trash</a>
                </div>
            </div>

            <!-- Profile dropdown -->
            <div class="profile-dropdown" onclick="toggleProfileDropdown()">
              <img src="<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Profile Photo" class="rounded-photo">
                <!-- Dropdown content -->
                <div class="dropdown-profile" id="profileDropdown">
                    <a href="profile.php">Profile</a>
                    <a href="#">Settings</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>