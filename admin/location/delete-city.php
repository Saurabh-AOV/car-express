<?php
session_start();
include '../includes/db.php';

// Check if city_id is set in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $city_id = intval($_GET['id']);

    // Check if the city exists
    $checkQuery = "SELECT * FROM location_city WHERE city_id = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("i", $city_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Delete the city
        $deleteQuery = "DELETE FROM location_city WHERE city_id = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("i", $city_id);

        if ($stmt->execute()) {
            $_SESSION['success'] = "City deleted successfully!";
        } else {
            $_SESSION['error'] = "Failed to delete city. Please try again.";
        }
    } else {
        $_SESSION['error'] = "City not found!";
    }
} else {
    $_SESSION['error'] = "Invalid city ID!";
}

// Redirect back to city listing page
header("Location: city.php");
exit();
?>
