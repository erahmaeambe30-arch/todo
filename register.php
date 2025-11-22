<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($email) || empty($password)) {
        echo "<script>alert('All fields are required.');</script>";
        exit;
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);

    // Check if username exists
    $stmtUser = $conn->prepare("SELECT id FROM users WHERE username=?");
    $stmtUser->bind_param("s", $username);
    $stmtUser->execute();
    $resultUser = $stmtUser->get_result();

    if ($resultUser->num_rows > 0) {
        echo "<script>alert('Username already exists. Try another one.');</script>";
        exit;
    }

    // Check if email exists
    $stmtEmail = $conn->prepare("SELECT id FROM users WHERE email=?");
    $stmtEmail->bind_param("s", $email);
    $stmtEmail->execute();
    $resultEmail = $stmtEmail->get_result();

    if ($resultEmail->num_rows > 0) {
        echo "<script>alert('Email already registered.');</script>";
        exit;
    }

    // Insert new user
    $stmtInsert = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmtInsert->bind_param("sss", $username, $email, $hashed);

    if ($stmtInsert->execute()) {
        echo "<script>window.location='login.php';</script>";
    } else {
        echo "<script>alert('Something went wrong. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - To-Do List</title>
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

    input::placeholder {
      color: #ccc;
    }

    input:focus {
      background: rgba(255, 255, 255, 0.35);
    }

    .intro-text {
    margin-bottom: 15px;
    font-weight: bold; 
  }
    .login-features {
    list-style-type: none;
    padding: 0;
    margin: 0;
  }
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

    .footer-text {
      margin-top: 15px;
      font-size: 0.9rem;
    }

    .footer-text a {
      color: #a6e1fa;
      text-decoration: none;
    }

    .footer-text a:hover {
      text-decoration: underline;
    }

    @media (max-width: 400px) {
      .login-container {
        width: 90%;
        padding: 30px 20px;
      }
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="logo">
      <img src="IMG/logo image.png" alt="To-Do List Logo">
      <h2>To-Do List</h2>
    </div>

  <div class="welcome">
  <p class="intro-text">Create Your Account To Start Organizing Your Tasks.</p>
  <ul class="login-features">
    <li>Simple Task Management</li>
    <li>Productivity Boost</li>
    <li>Accessibility</li>
    <li>Customize</li>
    <li>Organize</li>
  </ul>
</div>
    
    <form method="POST">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" placeholder="Enter your username" required>
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" placeholder="Enter your email" required>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Enter your password" required>
      </div>

      <button type="submit" class="btn"><i class="fa fa-user-plus"></i> Register</button>
    </form>

    <div class="footer-text">
      Already have an account? <a href="login.php">Login</a>
    </div>
  </div>
</body>
</html>
