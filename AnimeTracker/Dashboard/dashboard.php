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
    <h1>Welcome, <?= htmlspecialchars($username) ?>!</h1>
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

  <!-- Joke Ad Pop-up -->
  <div id="jokeAd" style="display:none; position:fixed; top:20%; left:35%; width:320px; padding:20px; background:black; border:2px solid #ccc; box-shadow:0 0 15px rgba(0,0,0,0.5); z-index:9999; text-align:center; border-radius:10px;">
    <h2 id="adTitle">🔥 Local Women Near You! 🔥</h2>
    <p id="adText">Find singles in <strong>Munster</strong> looking for love!</p>
    <img id="adImage" src="https://via.placeholder.com/300x180.png?text=Local+Singles" alt="Local Singles" style="width:100%; height:auto; margin:15px 0; border-radius:8px;">
    <button onclick="closeAd()" style="padding:10px 20px; background:red; color:white; border:none; border-radius:5px; cursor:pointer;">Close</button>
  </div>

  <script src="../js/animeTrackerVanilla.js"></script>

  <!-- Joke Ad Script -->
  <script>
    const ads = [
      {
        title: "🔥 Local Women Near You! 🔥",
        text: "Find singles in <strong>Munster</strong> looking for love!",
        image: "https://thafd.bing.com/th/id/OIP.WJnGsEtzkYqEQDPHHB_ytwHaHa?rs=1&pid=ImgDetMain"
      },
      {
        title: "💰 Rich Singles Await! 💰",
        text: "Millionaires in <strong>Munster</strong> are waiting to meet you!",
        image: "https://thafd.bing.com/th/id/OIP.WJnGsEtzkYqEQDPHHB_ytwHaHa?rs=1&pid=ImgDetMain"
      },
      {
        title: "🎯 Meet Fun Gamers Nearby!",
        text: "Gamers in <strong>Munster</strong> want to play with you!",
        image: "https://thafd.bing.com/th/id/OIP.WJnGsEtzkYqEQDPHHB_ytwHaHa?rs=1&pid=ImgDetMain"
      },
      {
        title: "🏋️‍♀️ Fit Singles in Munster!",
        text: "Find gym partners who never skip leg day!",
        image: "https://thafd.bing.com/th/id/OIP.WJnGsEtzkYqEQDPHHB_ytwHaHa?rs=1&pid=ImgDetMain"
      }
    ];

    function showJokeAd() {
      const randomAd = ads[Math.floor(Math.random() * ads.length)];
      document.getElementById('adTitle').innerHTML = randomAd.title;
      document.getElementById('adText').innerHTML = randomAd.text;
      document.getElementById('adImage').src = randomAd.image;
      document.getElementById('jokeAd').style.display = 'block';
    }

    function closeAd() {
      document.getElementById('jokeAd').style.display = 'none';
    }

    // Show ad after 5 seconds
    setTimeout(showJokeAd, 5000);
  </script>

</body>
</html>
