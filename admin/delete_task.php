<?php
session_start();
include('../db_connect.php');

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: manage_tasks.php");
    exit();
}

$id = $_GET['id'];

// Delete task
$sql = "DELETE FROM tasks WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: manage_tasks.php");
exit();
?>
