<?php
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : null;
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $product_condition = $_POST['product_condition'];
    $year_of_registration = $_POST['year_of_registration'];
    $fuel_type = $_POST['fuel_type'];
    $transmission = $_POST['transmission'];
    $mileage = $_POST['mileage'];
    $number_of_owners = $_POST['number_of_owners'];
    $tags = $_POST['tags'];
    $car_brand = $_POST['car_brand'];
    $car_model = $_POST['car_model'];
    $car_variant = $_POST['car_variant'];
    $location_city = $_POST['location_city'];
    $location_state = $_POST['location_state'];
    $location_pin_code = $_POST['location_pin_code'];

    // Handle image upload
    if ($_FILES['product_image']['name']) {
        $targetDir = "uploads/";
        $fileName = basename($_FILES["product_image"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        move_uploaded_file($_FILES["product_image"]["tmp_name"], $targetFilePath);
    } else {
        $targetFilePath = NULL;
    }

    if ($product_id) {
        // Update existing car
        $query = "UPDATE cars SET product_name=?, price=?, description=?, product_condition=?, year_of_registration=?, fuel_type=?, transmission=?, mileage=?, number_of_owners=?, tags=?, car_brand=?, car_model=?, car_variant=?, location_city=?, location_state=?, location_pin_code=?, product_image=? WHERE product_id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sississiiisssssssi", $product_name, $price, $description, $product_condition, $year_of_registration, $fuel_type, $transmission, $mileage, $number_of_owners, $tags, $car_brand, $car_model, $car_variant, $location_city, $location_state, $location_pin_code, $targetFilePath, $product_id);
    } else {
        // Insert new car
        $query = "INSERT INTO cars (...) VALUES (...)";
        $stmt = $conn->prepare($query);
        // (Insert values as done earlier)
    }

    if ($stmt->execute()) {
        header("Location: list_cars.php");
        exit();
    } else {
        echo "Error updating car!";
    }
}
?>
