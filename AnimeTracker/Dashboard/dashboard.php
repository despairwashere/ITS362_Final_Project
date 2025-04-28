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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard - Anime Tracker</title>
  <link rel="stylesheet" href="../css/styles.css" />
</head>
<body class="dashboard-body">
  <header class="dashboard-header">
    <h1>Welcome, <?= $username ?>!</h1>
    <a href="../Login/login.php" class="logout-btn">Logout</a>
  </header>

  <main class="dashboard-main">
    <h2 class="section-title">🌸 Featured Anime</h2>
    <div class="search-bar">
      <input type="text" id="searchInput" placeholder="Search for an anime...">
      <button onclick="handleSearch()">Search</button>
    </div>
    <div id="animeList" class="anime-grid"></div>
  </main>

  <script src="js/animeTrackerVanilla.js"></script>
</body>
</html>


