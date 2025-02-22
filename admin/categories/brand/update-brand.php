<?php
include '../../includes/db.php';

header("Content-Type: application/json"); // Ensure JSON response

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'], $_POST['brand_name'])) {
    $id = intval($_POST['id']);
    $brand_name = trim($_POST['brand_name']);

    if (empty($brand_name)) {
        echo json_encode(["success" => false, "message" => "Brand name cannot be empty!"]);
        exit();
    }

    // Debugging output (Check if data is received correctly)
    error_log("Updating Brand ID: $id to Name: $brand_name");

    $query = "UPDATE car_brands SET brand_name = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        echo json_encode(["success" => false, "message" => "Database error: " . $conn->error]);
        exit();
    }

    $stmt->bind_param("si", $brand_name, $id);
    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update brand!"]);
    }
    exit();
}

echo json_encode(["success" => false, "message" => "Invalid request!"]);
exit();
?>
