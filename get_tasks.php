<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
  http_response_code(401);
  echo json_encode(['error' => 'Unauthorized']);
  exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $result = $conn->query("SELECT * FROM tasks WHERE id = $id AND user_id = $user_id");
  echo json_encode($result->fetch_assoc());
  exit;
}

$result = $conn->query("SELECT * FROM tasks WHERE user_id = $user_id ORDER BY id DESC");
$tasks = [];
while ($row = $result->fetch_assoc()) {
  $tasks[] = $row;
}
echo json_encode($tasks);
