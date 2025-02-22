<?php
session_start();
include '../includes/db.php';

if (isset($_GET['id'])) {
    $state_id = intval($_GET['id']); // Ensure ID is an integer

    // Check if the state exists
    $checkQuery = "SELECT * FROM location_state WHERE state_id = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("i", $state_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $_SESSION['error'] = "State not found!";
    } else {
        // Delete the state
        $deleteQuery = "DELETE FROM location_state WHERE state_id = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("i", $state_id);

        if ($stmt->execute()) {
            $_SESSION['success'] = "State deleted successfully!";
        } else {
            $_SESSION['error'] = "Failed to delete state!";
        }
    }
} else {
    $_SESSION['error'] = "Invalid request!";
}

header("Location: state.php");
exit();
?>
