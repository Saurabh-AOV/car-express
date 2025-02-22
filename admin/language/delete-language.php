<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../authentication/login.php");
    exit();
}

include '../includes/db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Ensure ID is an integer to prevent injection
    
    // Use prepared statements for security
    $stmt = $conn->prepare("DELETE FROM languages WHERE language_id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $_SESSION['delete_success'] = "Language deleted successfully!";
    } else {
        $_SESSION['delete_error'] = "Error deleting language!";
    }
    
    $stmt->close();
    $conn->close();
    
    // Redirect to the list page
    header("Location: list.php");
    exit();
} else {
    $_SESSION['delete_error'] = "Invalid language ID!";
    header("Location: list.php");
    exit();
}
?>
