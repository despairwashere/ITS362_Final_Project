<?php
session_start();
include('../db/db.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT UserID, Username, PasswordHash FROM Users WHERE Username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($userID, $dbUsername, $dbPasswordHash);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();

        if (password_verify($password, $dbPasswordHash)) {
            $_SESSION['user_id'] = $userID;
            $_SESSION['username'] = $dbUsername;

            header("Location: ../Dashboard/dashboard.php");
            exit();
        } else {
            echo "Invalid credentials!";
        }
    } else {
        echo "User not found!";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Anime Tracker</title>
    <link rel="stylesheet" href="../css/styles.css">

    <style>
        .login-button {
            position: relative;
            transition: transform 0.3s ease;
        }
    </style>
</head>
<body class="login-body">

<div class="login-container">
    <h2>Welcome Back!</h2>
    <p class="subtitle">Log in to continue✨</p>
    <form action="login.php" method="POST" class="login-form">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="login-button" id="loginButton">Login</button>
    </form>

    <div class="links">
        <p>Don't have an account? <a href="../Signup/sign-up.php">Sign up here</a></p>
        <p>Admin? <a href="../Login/adminlogin.php">Login here</a></p>
    </div>
</div>

<script>
    const loginButton = document.getElementById('loginButton');
    let hoverTimer;
    let moveInterval;
    let resetTimer;

    loginButton.addEventListener('mouseenter', () => {
        hoverTimer = setTimeout(() => {
            // Start moving randomly every 0.5 seconds
            moveInterval = setInterval(() => {
                const randomX = Math.floor(Math.random() * 200) - 100; // Random between -100px and 100px
                const randomY = Math.floor(Math.random() * 200) - 100;
                loginButton.style.transform = `translate(${randomX}px, ${randomY}px)`;
            }, 500);

            // Reset back to normal after 15 seconds
            resetTimer = setTimeout(() => {
                clearInterval(moveInterval);
                loginButton.style.transform = 'translate(0, 0)';
            }, 15000);

        }, 5000); // Wait 5 seconds hovering
    });

    loginButton.addEventListener('mouseleave', () => {
        clearTimeout(hoverTimer);
    });
</script>

</body>
</html>
