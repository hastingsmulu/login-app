<?php
session_start();

// Get the time remaining from the query string
$time_remaining = isset($_GET['time_remaining']) ? intval($_GET['time_remaining']) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Locked</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f3f4f6;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            text-align: center;
        }

        h1 {
            font-size: 1.8em;
            color: #ff4757;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.1em;
            color: #555;
        }

        #timer {
            font-size: 1.5em;
            font-weight: bold;
            color: #ff6b6b;
        }

        .redirect-message {
            margin-top: 15px;
            font-size: 0.9em;
            color: #888;
        }

        @media (max-width: 768px) {
            .container {
                width: 90%;
            }

            h1 {
                font-size: 1.5em;
            }

            p {
                font-size: 1em;
            }
        }
    </style>
    <script>
        // Countdown timer
        let timeRemaining = <?php echo $time_remaining; ?>;
        
        function startCountdown() {
            let timerDisplay = document.getElementById('timer');

            let countdown = setInterval(() => {
                let minutes = Math.floor(timeRemaining / 60);
                let seconds = timeRemaining % 60;

                seconds = seconds < 10 ? '0' + seconds : seconds;

                timerDisplay.textContent = `${minutes}:${seconds}`;
                timeRemaining--;

                // When the time runs out, redirect to login
                if (timeRemaining < 0) {
                    clearInterval(countdown);
                    window.location.href = 'logout.php'; // Redirect to login page
                }
            }, 1000);
        }

        window.onload = startCountdown;
    </script>
</head>
<body>
    <div class="container">
        <h1>Account Locked</h1>
        <p>Your account has been temporarily locked due to multiple failed login attempts.</p>
        <p>Please wait for <span id="timer"></span> before trying again.</p>
        <p class="redirect-message">You will be redirected to the login page automatically when the timer ends.</p>
    </div>
</body>
</html>
