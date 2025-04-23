<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../Login/login.php"); // Redirect to login if not logged in
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Anime Tracker</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<header>
    <h1>Welcome, <?= $username ?>!</h1>
    <a href="../Login/login.php">Logout</a>
</header>

<h2>Featured Anime</h2>
<!-- This section will dynamically fetch and display featured anime using JavaScript and AJAX -->
<div id="animeList"></div>

<script src="../js/animeTracker.js" type="module"></script>

</body>
</html>
