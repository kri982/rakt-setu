<?php
require_once 'config/db.php';

// Total donors count
$totalDonors = $conn->query("SELECT COUNT(*) as c FROM users WHERE role='donor'")->fetch_assoc()['c'] ?? 0;

// Total requests
$totalRequests = $conn->query("SELECT COUNT(*) as c FROM blood_requests")->fetch_assoc()['c'] ?? 0;

// Total camps
$totalCamps = $conn->query("SELECT COUNT(*) as c FROM camps")->fetch_assoc()['c'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <meta name="theme-color" content="#D32F2F">
  <title>Rakt Setu — Blood Donor Platform</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

  <!-- APP BAR -->
  <header class="app-bar">
    <div class="container">
      <div class="brand">
        <div class="logo-3d">
          <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2C12 2 4 10.5 4 15.5C4 19.6 7.6 22 12 22C16.4 22 20 19.6 20 15.5C20 10.5 12 2 12 2Z" fill="#D32F2F"/>
            <path d="M12 6C12 6 7 11.5 7 15C7 17.2 9.2 18.5 12 18.5C14.8 18.5 17 17.2 17 15C17 11.5 12 6 12 6Z" fill="#FF5252" opacity="0.7"/>
          </svg>
        </div>
        <div>
          <div class="brand-text">Rakt Setu</div>
        </div>
      </div>
      <button class="theme-toggle" id="themeBtn" onclick="toggleTheme()">🌙</button>
    </div>
  </header>

  <main class="container">

    <!-- HERO -->
    <section class="hero fade-in">
      <h1>Every Drop Counts.</h1>
      <p>Find blood donors near you. Save a life with one connection.</p>
    </section>

    <!-- STATS -->
    <div class="stats-row stagger">
      <div class="stat-box">
        <span class="num"><?= $totalDonors ?></span>
        <span class="lbl">Donors</span>
      </div>
      <div class="stat-box">
        <span class="num"><?= $totalRequests ?></span>
        <span class="lbl">Requests</span>
      </div>
      <div class="stat-box">
        <span class="num"><?= $totalCamps ?></span>
        <span class="lbl">Camps</span>
      </div>
    </div>

    <!-- QUICK ACTIONS -->
    <h2 style="font-size:1.15rem;margin:24px 0 12px;">Quick Actions</h2>
    <div class="quick-grid stagger">
      <a href="search.php" class="quick-tile">
        <span class="tile-icon">🔍</span>
        <span class="tile-label">Find Donor</span>
      </a>
      <a href="request.php" class="quick-tile">
        <span class="tile-icon">🩸</span>
        <span class="tile-label">Request Blood</span>
      </a>
      <a href="register.php" class="quick-tile">
        <span class="tile-icon">❤️</span>
        <span class="tile-label">Become Donor</span>
      </a>
      <a href="requests.php" class="quick-tile">
        <span class="tile-icon">📋</span>
        <span class="tile-label">All Requests</span>
      </a>
    </div>

    <!-- CTA -->
    <a href="register.php" class="btn btn-primary mt-3" style="display:flex;">
      ❤️ Join as Donor
    </a>

    <div class="divider"></div>

    <p class="text-center" style="color:var(--text-dim);font-size:0.82rem;">
      🔒 Privacy-first. Your phone number stays protected.
    </p>

  </main>

  <!-- BOTTOM NAV -->
  <nav class="bottom-nav">
    <div class="nav-inner">
      <a href="index.php" class="nav-item active">
        <span class="ico">🏠</span>
        <span>Home</span>
      </a>
      <a href="search.php" class="nav-item">
        <span class="ico">🔍</span>
        <span>Search</span>
      </a>
      <a href="requests.php" class="nav-item">
        <span class="ico">🩸</span>
        <span>Requests</span>
      </a>
      <a href="dashboard.php" class="nav-item">
        <span class="ico">👤</span>
        <span>Profile</span>
      </a>
    </div>
  </nav>

  <script src="assets/js/app.js"></script>
</body>
</html>
