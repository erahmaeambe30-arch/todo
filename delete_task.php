<?php
session_start();
include 'db_connect.php';


if (!isset($_SESSION['user_id'])) die("Unauthorized");

$id = $_GET['id'] ?? '';

if (!$id) die("No task specified");

$stmt = $conn->prepare("DELETE FROM tasks WHERE id=? AND user_id=?");
$stmt->bind_param("ii", $id, $_SESSION['user_id']);

if ($stmt->execute()) {
    echo "Task deleted successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
