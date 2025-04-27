<?php
session_start();
include('../db/db.php'); // Adjust path as needed

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Get user with matching username and check if admin
    $stmt = $conn->prepare("SELECT UserID, Username, PasswordHash FROM Users WHERE Username = ? AND IsAdmin = TRUE");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userID, $dbUsername, $dbPasswordHash);
        $stmt->fetch();

        if (password_verify($password, $dbPasswordHash)) {
            $_SESSION['admin_id'] = $userID;
            $_SESSION['admin_username'] = $dbUsername;

            header("Location: ../admin/admin.php"); // Only admins get here
            exit();
        } else {
            echo "Invalid credentials!";
        }
    } else {
        echo "Admin not found!";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - Anime Tracker</title>
    <link rel="stylesheet" href="../css/adminstyles.css">
</head>
<body>
    <h2>Admin Login</h2>
    <form action="adminlogin.php" method="POST">
        <input type="text" name="username" placeholder="Admin Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
