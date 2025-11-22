<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) die("Unauthorized");

$id = $_POST['id'] ?? '';
$title = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';
$priority = $_POST['priority'] ?? 'medium';

if (!$id || !$title) die("Missing data");

$stmt = $conn->prepare("UPDATE tasks SET title=?, description=?, priority=? WHERE id=? AND user_id=?");
$stmt->bind_param("sssii", $title, $description, $priority, $id, $_SESSION['user_id']);

if ($stmt->execute()) {
    echo "Task updated successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
