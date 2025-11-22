<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) die("Unauthorized");

$id = $_GET['id'] ?? '';
if (!$id) die("No task specified");

// Get current status
$res = $conn->query("SELECT completed FROM tasks WHERE id=$id AND user_id=".$_SESSION['user_id']);
if ($res->num_rows == 0) die("Task not found");
$row = $res->fetch_assoc();
$new_status = $row['completed'] ? 0 : 1;

$stmt = $conn->prepare("UPDATE tasks SET completed=? WHERE id=? AND user_id=?");
$stmt->bind_param("iii", $new_status, $id, $_SESSION['user_id']);
$stmt->execute();

$stmt->close();
$conn->close();
?>
