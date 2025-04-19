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
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<h2>Sign Up</h2>
<form action="sign-up.php" method="POST">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Sign Up</button>
</form>

<p>Already have an account? <a href="../Login/login.php">Login here</a></p>

</body>
</html>
