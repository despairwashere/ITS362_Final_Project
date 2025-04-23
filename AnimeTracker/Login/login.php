<?php
session_start();
include('../db/db.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if user exists in the database
    $stmt = $conn->prepare("SELECT UserID, Username, PasswordHash FROM Users WHERE Username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($userID, $dbUsername, $dbPasswordHash);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $dbPasswordHash)) {
            $_SESSION['user_id'] = $userID;
            $_SESSION['username'] = $dbUsername;

            header("Location: ../Dashboard/dashboard.php"); // Redirect to dashboard after login
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
</head>
<body class="login-body">

<div class="login-container">
    <h2>Welcome Back!</h2>
    <p class="subtitle">Log in to continue✨</p>
    <form action="login.php" method="POST" class="login-form">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <div class="links">
        <p>Don't have an account? <a href="../Signup/sign-up.php">Sign up here</a></p>
        <p>Admin? <a href="../Login/adminlogin.php">Login here</a></p>
    </div>
</div>

</body>
</html>

