<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: white;
            margin: 0;
        }
        .login-container{
            position: relative;
            background-color: #800000;
            color: white;
            padding: 20px 40px;
            font-family: Consolas;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 400px;
        }
         
        h2 {
            text-align: center;
            color: #ffffff;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #ffffff;
        }
        input[type="text"],
        input[type="password"] {
            width: 95%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 0px;
            box-sizing: border-box;
        }
        button {
            width: 90%;
            padding: 10px;
            background-color: #800000;
			 border: 1px solid #671010e3;
            border: none;
            border-radius: 0px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background-color: #a90909e3;
        }
        .error {
            color: red;
            text-align: left;
            margin-top: 0px;
        } .striped {
            width: 40px;
            height: 100%;
            background: repeating-linear-gradient(
                45deg,
                white,
                white 5px,
                rgba(255, 255, 255, 0.5) 5px,
                rgba(255, 255, 255, 0.5) 10px
            );
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
        }
		.rounded-photo {
    width: 100px; /* Adjust size as needed */
    height: 100px; /* Adjust size as needed */
    border-radius: 50%;
    object-fit: cover; /* Ensures the image covers the container */
}
        .corner-lines {
            position: absolute;
            width: calc(100% + 30px);
            height: calc(100% + 30px);
            top: -15px;
            left: -15px;
            pointer-events: none;
        }
        .corner-lines::before, .corner-lines::after, .corner-lines span::before, .corner-lines span::after {
            content: '';
            position: absolute;
            width: 15px;
            height: 15px;
            border: 2px solid #800000;
        }
        .corner-lines::before {
            top: 0;
            left: 0;
            border-right: none;
            border-bottom: none;
        }
        .corner-lines::after {
            top: 0;
            right: 0;
            border-left: none;
            border-bottom: none;
        }
        .corner-lines span::before {
            bottom: 0;
            left: 0;
            border-right: none;
            border-top: none;
        }
        .corner-lines span::after {
            bottom: 0;
            right: 0;
            border-left: none;
            border-top: none;
        }
    </style>
</head>
<body>
    <div class="login-container">
	 <div class="corner-lines"><span></span></div>
        <div class="striped"></div>
		<div class="error">
            <?php
            session_start();
            // Display error messages if any
            if (isset($_SESSION['error_message'])) {
                echo htmlspecialchars($_SESSION['error_message']);
				 echo"<h2 class='error'style='width: 90px;'>Try Again</h2>";
                unset($_SESSION['error_message']); // Clear the message after displaying it
				
            } else{
                      echo"<h2>Login </h2>";
                      }
			
				 
            ?>
        </div>
        
		<br>
        <form action="login.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
        
    </div>
</body>
</html>
