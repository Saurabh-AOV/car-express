<?php
include '../includes/db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid car ID");
}

$product_id = $_GET['id'];

// Fetch car details
$query = "SELECT * FROM cars WHERE product_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Car not found!");
}

$car = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'process_car.php'; // Process the update logic
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Car</title>
</head>
<body>
    <h2>Edit Car Details</h2>
    <form action="process_car.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="product_id" value="<?= $car['product_id'] ?>">

        <input type="text" name="product_name" value="<?= $car['product_name'] ?>" required><br>
        <input type="number" name="price" value="<?= $car['price'] ?>" required><br>
        <textarea name="description"><?= $car['description'] ?></textarea><br>

        <select name="product_condition">
            <option value="New" <?= $car['product_condition'] == 'New' ? 'selected' : '' ?>>New</option>
            <option value="Used" <?= $car['product_condition'] == 'Used' ? 'selected' : '' ?>>Used</option>
        </select><br>

        <input type="number" name="year_of_registration" value="<?= $car['year_of_registration'] ?>" required><br>
        <input type="text" name="fuel_type" value="<?= $car['fuel_type'] ?>" required><br>

        <select name="transmission">
            <option value="Manual" <?= $car['transmission'] == 'Manual' ? 'selected' : '' ?>>Manual</option>
            <option value="Automatic" <?= $car['transmission'] == 'Automatic' ? 'selected' : '' ?>>Automatic</option>
        </select><br>

        <input type="number" name="mileage" value="<?= $car['mileage'] ?>" required><br>
        <input type="number" name="number_of_owners" value="<?= $car['number_of_owners'] ?>" required><br>
        <input type="text" name="tags" value="<?= $car['tags'] ?>"><br>
        <input type="text" name="car_brand" value="<?= $car['car_brand'] ?>"><br>
        <input type="text" name="car_model" value="<?= $car['car_model'] ?>"><br>
        <input type="text" name="car_variant" value="<?= $car['car_variant'] ?>"><br>
        <input type="text" name="location_city" value="<?= $car['location_city'] ?>"><br>
        <input type="text" name="location_state" value="<?= $car['location_state'] ?>"><br>
        <input type="text" name="location_pin_code" value="<?= $car['location_pin_code'] ?>"><br>

        <label>Change Image:</label>
        <input type="file" name="product_image"><br>
        <p>Current Image: <?= $car['product_image'] ? '<img src="'.$car['product_image'].'" width="100">' : 'No image' ?></p>

        <button type="submit" name="update">Update Car</button>
    </form>
</body>
</html>
