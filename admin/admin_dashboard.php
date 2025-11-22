<?php
session_start();
include('../db_connect.php'); 

$error = "";

// Block access if not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

$admin_name = $_SESSION['admin_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard - To-Do List</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
/* Body & Layout */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    display: flex;
    background: #fce4f5;
}

/* Sidebar */
.sidebar {
    width: 220px;
    height: 100vh;
    background: purple;
    color: #fff;
    display: flex;
    flex-direction: column;
    padding-top: 30px;
    position: fixed;
}

.sidebar h2 {
    text-align: center;
    margin-bottom: 30px;
    font-size: 22px;
}

.sidebar a {
    display: block;
    padding: 15px 20px;
    color: #fff;
    text-decoration: none;
    margin: 5px 10px;
    border-radius: 8px;
    transition: 0.3s;
}

.sidebar a:hover {
    background: pink;
    transform: scale(1.03);
}

/* Main content */
.main {
    margin-left: 240px;
    padding: 30px;
    width: calc(100% - 240px);
}

/* Dashboard Cards */
.card-container {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    margin-top: 20px;
}

.card {
    background: #fff;
    padding: 25px;
    flex: 1 1 200px;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    text-align: center;
}

.card h3 {
    color: #ff4da6;
    margin-bottom: 10px;
}

.card span {
    font-size: 30px;
    font-weight: bold;
}

/* CRUD Buttons */
.crud-links {
    margin-top: 30px;
}

.crud-links a {
    display: inline-block;
    margin: 5px;
    padding: 12px 20px;
    background: #ff4da6;
    color: #fff;
    text-decoration: none;
    border-radius: 8px;
    transition: 0.3s;
}

.crud-links a:hover {
    background: #ff1a8c;
}
</style>
</head>
<body>

<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="admin_dashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a>
    <a href="manage_users.php"><i class="fa-solid fa-users"></i> Manage Users</a>
    <a href="manage_tasks.php"><i class="fa-solid fa-list-check"></i> Manage Tasks</a>
    <a href="admin_logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
</div>

<div class="main">
    <h2>Welcome Admin👋</h2>
    <p>Use the sidebar to navigate or manage users/tasks directly below:</p>

    <div class="card-container">
        <div class="card">
            <h3>Total Users</h3>
            <span><?php
                include('../db_connect.php');
                $users_count = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
                echo $users_count;
            ?></span>
        </div>
        <div class="card">
            <h3>Total Tasks</h3>
            <span><?php
                $tasks_count = $conn->query("SELECT COUNT(*) AS total FROM tasks")->fetch_assoc()['total'];
                echo $tasks_count;
            ?></span>
        </div>
        </div>
    </div>

    <!-- CRUD Direct Links -->
    <div class="crud-links">
        <h3>User Management:</h3>
        <a href="manage_users.php"><i class="fa-solid fa-users"></i> Manage Users</a>
        <a href="delete_user.php?id=1" onclick="return confirm('Delete this user?')"><i class="fa-solid fa-trash"></i> Delete User</a>

        <h3>Task Management:</h3>
        <a href="manage_tasks.php"><i class="fa-solid fa-list-check"></i> Manage Tasks</a>
        <a href="delete_task.php?id=1" onclick="return confirm('Delete this task?')"><i class="fa-solid fa-trash"></i> Delete Task</a>
    </div>
</div>

</body>
</html>
