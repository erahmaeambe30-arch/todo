<?php
session_start();
include 'db_connect.php';


header("Content-Type: application/json; charset=UTF-8");
ob_clean(); 

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Unauthorized"
    ]);
    exit;
}

$user_id = $_SESSION['user_id'];
$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$priority = $_POST['priority'] ?? 'medium';

if ($title === '') {
    echo json_encode([
        "status" => "error",
        "message" => "Title required"
    ]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO tasks (user_id, title, description, priority) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isss", $user_id, $title, $description, $priority);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Task added successfully"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => $stmt->error
    ]);
}

$stmt->close();
$conn->close();
?>
