<?php
session_start();
include('../db_connect.php');

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Get user ID
if (!isset($_GET['id'])) {
    header("Location: manage_users.php");
    exit();
}

$id = $_GET['id'];

// Fetch user
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("User not found.");
}

// Update user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);

    $update_sql = "UPDATE users SET username = ?, email = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssi", $username, $email, $id);
    $update_stmt->execute();

    header("Location: manage_users.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit User</title>
</head>
<body>

<h2>Edit User</h2>
<a href="manage_users.php">⬅ Back</a>

<form method="POST">
    <label>Username:</label><br>
    <input type="text" name="username" value="<?= $user['username']; ?>" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?= $user['email']; ?>" required><br><br>

    <button type="submit">Update</button>
</form>

</body>
</html>
