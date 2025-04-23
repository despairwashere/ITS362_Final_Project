<?php
include('../db/db.php');

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordHash = password_hash($password, PASSWORD_DEFAULT); // Hash the password before storing

    // Insert user into database
    $stmt = $conn->prepare("INSERT INTO Users (Username, PasswordHash, Email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $passwordHash, $email);

    if ($stmt->execute()) {
        echo "User registered successfully!";
        header("Location: ../Login/login.php"); // Redirect to login page after successful registration
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Anime Tracker</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body class="login-body">

<div class="login-container">
    <h2>Join the Anime Journey!</h2>
    <p class="subtitle">Create your account to start tracking your favorite series 🌸</p>
    <form action="sign-up.php" method="POST" class="login-form">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Sign Up</button>
    </form>

    <div class="links">
        <p>Already have an account? <a href="../Login/login.php">Login here</a></p>
    </div>
</div>

</body>
</html>

