<?php
include_once __DIR__ . "/../includes/db.php";

// Check if user ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Invalid User ID!'); window.location.href='list.php';</script>";
    exit;
}

$user_id = $_GET['id'];

// Delete user from the database
$sql = "DELETE FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);

if (mysqli_stmt_execute($stmt)) {
    echo "<script>alert('User deleted successfully!'); window.location.href='list.php';</script>";
} else {
    echo "<script>alert('Error deleting user!'); window.location.href='list.php';</script>";
}
?>
