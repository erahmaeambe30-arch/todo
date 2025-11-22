<?php
session_start();
include('../db_connect.php');

$error = "";

// Default admin (optional)
$default_admin_email = "admin@example.com";
$default_admin_password = "admin123";

// Hash only for inserting initially, NOT every login
$hashed_default_password = password_hash($default_admin_password, PASSWORD_DEFAULT);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = mysqli_real_escape_string($conn, string: $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check admin from database
    $sql = "SELECT * FROM admin WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) === 1) {
        $admin = mysqli_fetch_assoc($result);

        if (password_verify($password, $admin['password'])) {

            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['name'];
            $_SESSION['admin_logged_in'] = true;

            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error = "Incorrect email or password.";
        }

    } else {

        // Allow TEMPORARY default login
        if ($email === $default_admin_email && $password === $default_admin_password) {

            $_SESSION['admin_id'] = 1;
            $_SESSION['admin_name'] = "Default Admin";
            $_SESSION['admin_logged_in'] = true;

            header("Location: admin_dashboard.php");
            exit();
        }

        $error = "Incorrect email or password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Admin Login - To-Do List</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
/* Body */
body {
    font-family: Arial, sans-serif;
    background: skyblue;
    height: 100vh;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Login Box */
.login-box {
    width: 380px;
    background: #06d1fff8;
    padding: 35px;
    border-radius: 15px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    text-align: center;
}

/* Head */
.login-box h2 {
    color: #ff4da6;
    margin-bottom: 25px;
}

/* Inputs */
input {
    width: 100%;
    padding: 12px;
    margin-bottom: 18px;
    border: 1px solid #ccc;
    border-radius: 8px;
}

/* Button */
.btn {
    width: 100%;
    padding: 12px;
    background: #ff4da6;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    color: #fff;
    cursor: pointer;
}

.btn:hover {
    background: purple;
}

/* Error */
.error {
    background: #ffe1ec;
    padding: 10px;
    border-radius: 8px;
    color: #cc004f;
    margin-bottom: 20px;
}

/* Links */
.links a {
    display: inline-block;
    margin: 10px 5px;
    text-decoration: none;
    padding: 8px 14px;
    border: 1px solid #ccc;
    border-radius: 8px;
    color: #333;
}
</style>
</head>

<body>

<div class="login-box">
    <h2>Admin Login</h2>

    <?php if($error): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Email</label>
        <input type="email" name="email" required placeholder="Enter email">

        <label>Password</label>
        <input type="password" name="password" required placeholder="Enter password">

        <button class="btn" type="submit">Login</button>
    </form>

    <div class="links">
        <a href="../login.php"><i class="fa-solid fa-user"></i> User Login</a>
    </div>
</div>

</body>
</html>
