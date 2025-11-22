<?php
session_start();
include 'db_connect.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: dashboard.php");
            exit;
        } else {
            $message = "Incorrect password.";
        }
    } else {
        $message = "No account found with that username.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - To-Do List</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}

body {
  height: 100vh;
  background-image: url("IMG/image.png");
  display: flex;
  justify-content: center;
  align-items: center;
  color: white;
  position: relative;
}

.login-container {
  background: rgba(255, 255, 255, 0.08);
  backdrop-filter: blur(12px);
  border-radius: 20px;
  padding: 40px;
  width: 400px;
  text-align: center;
  box-shadow: 0 0 20px rgba(0,0,0,0.2);
  animation: fadeInUp 1s ease;
  position: relative;
}

@keyframes fadeInUp {
  0% { transform: translateY(40px); opacity: 0; }
  100% { transform: translateY(0); opacity: 1; }
}

.logo {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  background: rgba(255,255,255,0.1);
  border-radius: 15px;
  padding: 10px 20px;
  margin-bottom: 20px;
  animation: bounceIn 1.2s ease;
}

.logo img {
  width: 60px;
  height: 60px;
  object-fit: contain;
}

.logo h2 {
  color: #9cd3ff;
  font-size: 32px;
  font-weight: bold;
  margin-top: 10px;
  text-align: center;
  letter-spacing: 1px;
}

@keyframes bounceIn {
  0% { transform: scale(0.8); opacity: 0; }
  50% { transform: scale(1.1); opacity: 1; }
  100% { transform: scale(1); }
}

.welcome {
  font-size: 1rem;
  margin-bottom: 20px;
  color: #ddd;
  animation: fadeIn 2s ease;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

.form-group {
  margin-bottom: 20px;
  text-align: left;
}

label {
  font-size: 0.9rem;
  margin-bottom: 5px;
  display: block;
}

input {
  width: 100%;
  padding: 10px 12px;
  border: none;
  border-radius: 8px;
  outline: none;
  font-size: 1rem;
  background: rgba(255, 255, 255, 0.2);
  color: white;
  transition: background 0.3s ease;
}

input::placeholder { color: #ccc; }
input:focus { background: rgba(255, 255, 255, 0.35); }

.intro-text { margin-bottom: 15px; font-weight: bold; }
.login-features { list-style-type: none; padding: 0; margin: 0; }

.btn {
  width: 100%;
  background: #7209b7;
  color: white;
  border: none;
  border-radius: 8px;
  padding: 10px;
  font-size: 1rem;
  cursor: pointer;
  transition: all 0.3s ease;
}

.btn:hover {
  background: #fe6ef5ff;
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(167, 41, 245, 0.3);
}

.footer-text { margin-top: 15px; font-size: 0.9rem; }
.footer-text a { color: #a6e1fa; text-decoration: none; }
.footer-text a:hover { text-decoration: underline; }

.message { color: #ff4c4c; margin-bottom: 15px; text-align:center; font-weight:bold; }

/* Floating Admin Button */
.admin-btn {
  position: absolute;
  top: 20px;
  right: 20px;
  background: purple;
  color: white;
  padding: 10px 15px;
  border-radius: 8px;
  font-weight: bold;
  text-decoration: none;
  box-shadow: 0 4px 10px rgba(0,0,0,0.2);
  transition: all 0.3s ease;
  z-index: 10;
}

.admin-btn:hover {
  background: pink;
  transform: translateY(-2px);
  box-shadow: 0 6px 15px rgba(0,0,0,0.3);
}

@media (max-width: 400px) {
  .login-container { width: 90%; padding: 30px 20px; }
}
</style>
</head>

<body>
  <!-- Floating Admin Login Button -->
<a href="admin/admin_login.php" class="admin-btn">Login as Admin</a>


  <div class="login-container">
    <div class="logo">
      <img src="IMG/logo image.png" alt="To-Do List Logo">
      <h2>To-Do List</h2>
    </div>

    <div class="welcome">
      <p class="intro-text">Welcome Back! Please sign in</p>
      <ul class="login-features">
        <li>Simple Task Management</li>
        <li>Productivity Boost</li>
        <li>Accessibility</li>
        <li>Customize</li>
        <li>Organize</li>
      </ul>
    </div>

    <?php if ($message != ''): ?>
      <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" placeholder="Enter your username" required>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Enter your password" required>
      </div>

      <button type="submit" class="btn"><i class="fa fa-sign-in-alt"></i> Sign In</button>
    </form>

    <div class="footer-text">
      Don't have an account? <a href="register.php">Register</a>
    </div>
  </div>
</body>
</html>
