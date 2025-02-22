<?php
session_start();
include '../../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_brand'])) {
    $brand_name = trim($_POST['brand_name']);

    if (empty($brand_name)) {
        $_SESSION['error'] = "Brand name is required!";
    } else {
        $checkQuery = "SELECT * FROM car_brands WHERE brand_name = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("s", $brand_name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['error'] = "Brand already exists!";
        } else {
            $insertQuery = "INSERT INTO car_brands (brand_name) VALUES (?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("s", $brand_name);
            if ($stmt->execute()) {
                $_SESSION['success'] = "Brand added successfully!";
            } else {
                $_SESSION['error'] = "Failed to add brand!";
            }
        }
    }
    header("Location: list.php");
    exit();
}
?>