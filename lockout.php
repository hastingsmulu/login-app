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
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: white;
            margin: 0;
        }
        .container {
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
        .text {
            display: flex;
            flex-direction: column;
            width: 100%;
        }
        .title {
            text-align: left;
        }
        .time {
            font-size: 32px;
            font-weight: bold;
            text-align: center;
        }
        .time-remaining {
            text-align: right;
        }
        .striped {
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
    <script>
        // Countdown timer
        let timeRemaining = <?php echo $time_remaining; ?>;
        
        function startCountdown() {
            let timerDisplay = document.getElementById('timer');

            let countdown = setInterval(() => {
				 let hours = Math.floor(timeRemaining / 3600);
                let minutes = Math.floor(timeRemaining / 60);
                let seconds = timeRemaining % 60;

                seconds = seconds < 10 ? '0' + seconds : seconds;

                timerDisplay.textContent = `-00:0${hours}:${minutes}:${seconds}`;
                timeRemaining--;

                // When the time runs out, redirect to login
                if (timeRemaining < 0) {
                    clearInterval(countdown);
                    window.location.href = 'logout.php'; // Redirect to login page
                }
            }, 1000);
        }

        window.onload = startCountdown;
    </script></head>
<body>
    <div class="container">
        <div class="corner-lines"><span></span></div>
        <div class="striped"></div>
        <div class="text">
           <div class="title" style=" width: 200px; height: 20px;">Account locked temporarily</div>
            <div class="time" id="timer"></div>
            <div class="time-remaining"  style=" width: 350px;">Time Remaining</div>
        </div>
    </div>

</body>
</html>
