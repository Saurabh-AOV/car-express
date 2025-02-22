<?php
session_start();
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'], $_POST['state_name'])) {
    $state_id = intval($_POST['id']);
    $state_name = trim($_POST['state_name']);

    if (empty($state_name)) {
        echo "error";
        exit;
    }

    // Update the state
    $updateQuery = "UPDATE location_state SET state_name = ? WHERE state_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("si", $state_name, $state_id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "error";
}
?>
