<?php
session_start();
include('../db/db.php');

// ERROR REPORTING FOR DEBUGGING
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Redirect if not logged in as admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login/adminlogin.php");
    exit();
}

// Handle Add User
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $isAdmin = isset($_POST['is_admin']) ? 1 : 0;

    $stmt = $conn->prepare("INSERT INTO Users (Username, PasswordHash, Email, IsAdmin) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $username, $password, $email, $isAdmin);
    $stmt->execute();
    $stmt->close();
}

// Handle Delete User
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $userID = $_POST['user_id'];

    // Prevent deleting self
    if ($userID != $_SESSION['admin_id']) {
        $stmt = $conn->prepare("DELETE FROM Users WHERE UserID = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch All Users
$users = $conn->query("SELECT UserID, Username, Email, IsAdmin, CreatedAt FROM Users ORDER BY CreatedAt DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Anime Tracker</title>
    <link rel="stylesheet" href="../css/adminstyles.css">
</head>
<body>

    <h2>Welcome, Admin <?= htmlspecialchars($_SESSION['admin_username']) ?>!</h2>

    <form action="logout.php" method="POST">
        <button type="submit">Logout</button>
    </form>

    <hr>

    <h3>Add New User</h3>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <label><input type="checkbox" name="is_admin"> Make Admin</label><br>
        <button type="submit" name="add_user">Add User</button>
    </form>

    <hr>

    <h3>All Users</h3>
    <table>
        <tr>
            <th>UserID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Is Admin</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $users->fetch_assoc()): ?>
            <tr>
                <td><?= $row['UserID'] ?></td>
                <td><?= htmlspecialchars($row['Username']) ?></td>
                <td><?= htmlspecialchars($row['Email']) ?></td>
                <td><?= $row['IsAdmin'] ? 'Yes' : 'No' ?></td>
                <td><?= $row['CreatedAt'] ?></td>
                <td>
                    <?php if ($row['UserID'] != $_SESSION['admin_id']): ?>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="user_id" value="<?= $row['UserID'] ?>">
                            <button type="submit" name="delete_user" onclick="return confirm('Delete this user?')">Delete</button>
                        </form>
                    <?php else: ?>
                        (You)
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>
