<?php
session_start();
include '../../includes/db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "Invalid brand ID!";
    header("Location: list.php");
    exit();
}

$brand_id = intval($_GET['id']);
$deleteQuery = "DELETE FROM car_brands WHERE id = ?";
$stmt = $conn->prepare($deleteQuery);
$stmt->bind_param("i", $brand_id);

if ($stmt->execute()) {
    $_SESSION['success'] = "Brand deleted successfully!";
} else {
    $_SESSION['error'] = "Failed to delete brand!";
}

header("Location: list.php");
exit();
?>
