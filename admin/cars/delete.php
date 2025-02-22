<?php
include '../includes/db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid request");
}

$product_id = $_GET['id'];

// Check if car exists
$query = "SELECT product_image FROM products WHERE product_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Listing not found!");
}

$car = $result->fetch_assoc();

// Delete car image if exists
if (!empty($car['product_image'])) {
    unlink($car['product_image']); // Delete image from server
}

// Delete car from database
$deleteQuery = "DELETE FROM products WHERE product_id = ?";
$stmt = $conn->prepare($deleteQuery);
$stmt->bind_param("i", $product_id);

if ($stmt->execute()) {
    header("Location: list.php?deleted=success");
    exit();
} else {
    echo "Error deleting car!";
}
?>
