<?php
session_start();
include('../db_connect.php');

// Block access if not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch all users
$sql = "SELECT * FROM users ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Users</title>

<style>
    body {
        font-family: Arial, sans-serif;
        background: #f2f2f2;
        margin: 0;
        padding: 20px;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 28px;
        color: #333;
    }

    a {
        text-decoration: none;
    }

    .back-btn {
        display: inline-block;
        margin-bottom: 20px;
        background: #555;
        padding: 10px 18px;
        color: #fff;
        border-radius: 6px;
        transition: 0.3s;
    }
    .back-btn:hover {
        background: #333;
    }

    table {
        width: 100%;
        background: white;
        border-collapse: collapse;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }

      .back-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 20px;
    background: purple;
    padding: 12px 20px;
    color: #fff;
    border-radius: 8px;
    font-size: 15px;
    font-weight: bold;
    transition: 0.3s ease-in-out;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
}

.back-btn:hover {
    background: pink;
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(0, 0, 0, 0.25);
}
    th {
        background: skyblue;
        color: white;
        padding: 12px;
        font-size: 16px;
    }

    td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
        font-size: 15px;
    }

    tr:hover {
        background: #f1f1f1;
    }

    .btn {
        padding: 7px 14px;
        border-radius: 4px;
        color: white;
        font-size: 14px;
        margin-right: 5px;
        text-decoration: none;
        transition: 0.3s;
    }

    .btn-edit {
        background: #2196F3;
    }
    .btn-edit:hover {
        background: #0b7dda;
    }

    .btn-danger {
        background: #e63946;
    }
    .btn-danger:hover {
        background: #c1121f;
    }
</style>
</head>
<body>

<h2>Manage Users</h2>

<a class="back-btn" href="admin_dashboard.php">⬅ Back to Dashboard</a>

<table>
<tr>
    <th>ID</th>
    <th>Username</th>
    <th>Email</th>
    <th>Actions</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= $row['id']; ?></td>
    <td><?= $row['username']; ?></td>
    <td><?= $row['email']; ?></td>
    <td>
        <a class="btn btn-edit" href="edit_user.php?id=<?= $row['id']; ?>">Edit</a>
        <a class="btn btn-danger" href="delete_user.php?id=<?= $row['id']; ?>"
           onclick="return confirm('Delete this user?');">Delete</a>
    </td>
</tr>
<?php endwhile; ?>

</table>

</body>
</html>
