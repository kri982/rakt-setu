<?php
require_once 'config/db.php';

$message = '';
$type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name   = trim($_POST['full_name'] ?? '');
    $email       = trim($_POST['email'] ?? '');
    $phone       = trim($_POST['phone'] ?? '');
    $password    = $_POST['password'] ?? '';
    $blood_group = $_POST['blood_group'] ?? '';
    $gender      = $_POST['gender'] ?? '';
    $dob         = $_POST['dob'] ?? null;
    $weight      = (int)($_POST['weight'] ?? 0);
    $city        = trim($_POST['city'] ?? '');
    $state       = trim($_POST['state'] ?? '');

    // Validation
    if ($full_name === '' || $email === '' || $phone === '' || $password === '' || $blood_group === '' || $city === '') {
        $message = 'Sab zaroori fields bharo.';
        $type = 'error';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Email sahi nahi hai.';
        $type = 'error';
    } elseif (strlen($password) < 6) {
        $message = 'Password kam se kam 6 characters ka ho.';
        $type = 'error';
    } else {
        // Email check
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            $message = 'Ye email pehle se registered hai.';
            $type = 'error';
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (full_name, email, phone, password, blood_group, gender, dob, weight, city, state) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssiss", $full_name, $email, $phone, $hashed, $blood_group, $gender, $dob, $weight, $city, $state);

            if ($stmt->execute()) {
                $message = 'Registration successful! Ab login karo.';
                $type = 'success';
            } else {
                $message = 'Kuch error aaya. Dobara try karo.';
                $type = 'error';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#D32F2F">
  <title>Register — Rakt Setu</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

  <header class="app-bar">
    <div class="container">
      <div class="brand">
        <div class="logo-3d">
          <svg viewBox="0 0 24 24" fill="none"><path d="M12 2C12 2 4 10.5 4 15.5C4 19.6 7.6 22 12 22C16.4 22 20 19.6 20 15.5C20 10.5 12 2 12 2Z" fill="#D32F2F"/></svg>
        </div>
        <div class="brand-text">Rakt Setu</div>
      </div>
      <button class="theme-toggle" id="themeBtn" onclick="toggleTheme()">🌙</button>
    </div>
  </header>

  <main class="container">
    <h1 class="page-title">Become a Donor</h1>
    <p class="page-sub">Ek baar register karo, zindagi bhar kisi ki madad karo.</p>

    <?php if ($message): ?>
      <div class="alert alert-<?= $type ?>"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST" class="stagger">
      <div class="form-group">
        <label class="form-label">Full Name *</label>
        <input type="text" name="full_name" class="form-control" placeholder="Aapka pura naam" required>
      </div>

      <div class="form-group">
        <label class="form-label">Email *</label>
        <input type="email" name="email" class="form-control" placeholder="example@gmail.com" required>
      </div>

      <div class="form-group">
        <label class="form-label">Phone *</label>
        <input type="tel" name="phone" class="form-control" placeholder="10-digit mobile number" pattern="[0-9]{10}" required>
      </div>

      <div class="form-group">
        <label class="form-label">Password *</label>
        <input type="password" name="password" class="form-control" placeholder="Min 6 characters" required>
      </div>

      <div class="form-group">
        <label class="form-label">Blood Group *</label>
        <select name="blood_group" class="form-control" required>
          <option value="">Select Blood Group</option>
          <option value="A+">A+</option>
          <option value="A-">A-</option>
          <option value="B+">B+</option>
          <option value="B-">B-</option>
          <option value="AB+">AB+</option>
          <option value="AB-">AB-</option>
          <option value="O+">O+</option>
          <option value="O-">O-</option>
        </select>
      </div>

      <div class="form-group">
        <label class="form-label">Gender</label>
        <select name="gender" class="form-control">
          <option value="">Select</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
          <option value="Other">Other</option>
        </select>
      </div>

      <div class="form-group">
        <label class="form-label">Date of Birth</label>
        <input type="date" name="dob" class="form-control">
      </div>

      <div class="form-group">
        <label class="form-label">Weight (kg)</label>
        <input type="number" name="weight" class="form-control" placeholder="Minimum 50 kg" min="0" max="200">
      </div>

      <div class="form-group">
        <label class="form-label">City *</label>
        <input type="text" name="city" class="form-control" placeholder="Aapka shehar" required>
      </div>

      <div class="form-group">
        <label class="form-label">State</label>
        <input type="text" name="state" class="form-control" placeholder="Aapka rajya">
      </div>

      <button type="submit" class="btn btn-primary mt-2">❤️ Register</button>
    </form>

    <p class="text-center mt-3" style="color:var(--text-dim);font-size:0.88rem;">
      Pehle se account hai? <a href="login.php" style="color:var(--red-light);font-weight:600;">Login karo</a>
    </p>

  </main>

  <nav class="bottom-nav">
    <div class="nav-inner">
      <a href="index.php" class="nav-item"><span class="ico">🏠</span><span>Home</span></a>
      <a href="search.php" class="nav-item"><span class="ico">🔍</span><span>Search</span></a>
      <a href="requests.php" class="nav-item"><span class="ico">🩸</span><span>Requests</span></a>
      <a href="dashboard.php" class="nav-item"><span class="ico">👤</span><span>Profile</span></a>
    </div>
  </nav>

  <script src="assets/js/app.js"></script>
</body>
</html>
