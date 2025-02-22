<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../authentication/login.php");
    exit();
}

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/db.php'; // Database connection

// Get product ID from URL
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : 0;

if ($product_id == 0) {
    echo "<script>alert('Invalid Car ID'); window.location.href='list.php';</script>";
    exit;
}

// Fetch car details
$sql = "SELECT * FROM products WHERE product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$car = $result->fetch_assoc();

if (!$car) {
    echo "<script>alert('Car not found'); window.location.href='list.php';</script>";
    exit;
}

// Fetch states
$stateQuery = "SELECT state_id, state_name FROM location_state";
$stateResult = $conn->query($stateQuery);

// Fetch cities based on the selected state
$cityQuery = "SELECT city_id, city_name FROM location_city WHERE state_id = ?";
$cityStmt = $conn->prepare($cityQuery);
$cityStmt->bind_param("i", $car['location_state']);
$cityStmt->execute();
$cityResult = $cityStmt->get_result();
$cities = $cityResult->fetch_all(MYSQLI_ASSOC);
?>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = trim($_POST['product_name']);
    $price = (int)$_POST['price'];
    $description = trim($_POST['description']);
    $product_condition = $_POST['product_condition'];
    $status = $_POST['status'];
    $year_of_registration = $_POST['year_of_registration'];
    $fuel_type = $_POST['updated_fuel_type'];
    $transmission = $_POST['transmission'];
    $mileage = (int)$_POST['mileage'];
    $number_of_owners = (int)$_POST['number_of_owners'];
    $tags = trim($_POST['tags']);
    $car_brand = $_POST['manufacturer'];
    $car_model = $_POST['model'];
    $car_variant = $_POST['variant'];
    $location_city = $_POST['location_city'];
    $location_state = $_POST['location_state'];
    $location_pin_code = $_POST['pincode'];
    
    // Handle image upload
    $uploaded_images = [];
    if (!empty($_FILES['product_image']['name'][0])) {
        $target_dir = "../assets/images/products/$user_id/$product_id/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        foreach ($_FILES['product_image']['tmp_name'] as $key => $tmp_name) {
            $file_name = basename($_FILES['product_image']['name'][$key]);
            $target_file = $target_dir . $file_name;
            if (move_uploaded_file($tmp_name, $target_file)) {
                $uploaded_images[] = $target_file;
            }
        }
    }

    // Convert image paths to string
    $product_image = !empty($uploaded_images) ? implode(",", $uploaded_images) : $_POST['existing_images'];

    // Update query
    $stmt = $conn->prepare("UPDATE products SET product_name=?, price=?, description=?, product_condition=?, status=?, year_of_registration=?, fuel_type=?, transmission=?, mileage=?, number_of_owners=?, tags=?, car_brand=?, car_model=?, car_variant=?, location_city=?, location_state=?, location_pin_code=?, product_image=? WHERE product_id=?");
    $stmt->bind_param("sissssssiiisssiiisi", $product_name, $price, $description, $product_condition, $status, $year_of_registration, $fuel_type, $transmission, $mileage, $number_of_owners, $tags, $car_brand, $car_model, $car_variant, $location_city, $location_state, $location_pin_code, $product_image, $product_id);
    
    if ($stmt->execute()) {
        header("Location: list.php?success=Car updated successfully");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>


<div class="container main-container">
    <h3><i class="fa fa-edit"></i> Edit Car Listing</h3>

    <div class="row">
        <!-- Product ID -->
        <div class="col-md-6 mb-3">
            <label class="form-label">Product ID</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($car['product_id']) ?>" disabled>
        </div>

        <?php
        // Fetch user name from the users table based on user_id
        $userQuery = "SELECT username FROM users WHERE phone_number = ?";
        $stmt = $conn->prepare($userQuery);
        $stmt->bind_param("s", $car['user_id']);
        $stmt->execute();
        $userResult = $stmt->get_result();
        $user = $userResult->fetch_assoc();
        ?>

        <!-- User Name -->
        <div class="col-md-6 mb-3">
            <label class="form-label">User Name</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($user['username'] ?? 'N/A') ?>" disabled>
        </div>

    </div>

    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="product_id" value="<?= $car['product_id'] ?>">

        <div class="row">
            <!-- Car Name -->
            <div class="col-md-6 mb-3">
                <label class="form-label"><i class="fa fa-car"></i> Car Name</label>
                <input type="text" name="product_name" class="form-control" value="<?= htmlspecialchars($car['product_name']) ?>" required>
            </div>

            <!-- Price -->
            <div class="col-md-6 mb-3">
                <label class="form-label"><i class="fa fa-tag"></i> Price (₹)</label>
                <input type="number" name="price" class="form-control" value="<?= $car['price'] ?>" required>
            </div>

            <!-- Description -->
            <div class="col-md-6 mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description"> <?= htmlspecialchars($car['description']) ?> </textarea>
            </div>

            <!-- Car Condition -->
            <div class="col-md-6 mb-3">
                <label class="form-label"><i class="fa fa-wrench"></i> Condition</label>
                <select name="product_condition" class="form-select">
                    <option value="New" <?= $car['product_condition'] == 'New' ? 'selected' : '' ?>>New</option>
                    <option value="Used" <?= $car['product_condition'] == 'Used' ? 'selected' : '' ?>>Used</option>
                </select>
            </div>

            <!-- Year of registration -->
            <div class="col-md-6 mb-3">
                <label for="year_of_registration" class="form-label">Year of Registration</label>
                <input type="number" class="form-control" name="year_of_registration" value="<?= $car['year_of_registration'] ?>" required>
            </div>

            <!-- Status -->
            <div class="col-md-6 mb-3">
                <label class="form-label"><i class="fa fa-toggle-on"></i> Status</label>
                <select name="status" class="form-select">
                    <option value="Active" <?= $car['status'] == 'Active' ? 'selected' : '' ?>>Active</option>
                    <option value="Pending" <?= $car['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="Sold" <?= $car['status'] == 'Sold' ? 'selected' : '' ?>>Sold</option>
                </select>
            </div>

            <!-- Fuel Type -->
            <div class="col-md-6 mb-3">
                <label for="fuel" class="form-label"><i class="fa fa-gas-pump"></i> Fuel Type</label>
                <select id="fuel" name="updated_fuel_type" class="form-select">
                    <option value="Petrol" <?= ($car['fuel_type'] == 'Petrol') ? 'selected' : '' ?>>Petrol</option>
                    <option value="Diesel" <?= ($car['fuel_type'] == 'Diesel') ? 'selected' : '' ?>>Diesel</option>
                    <option value="CNG" <?= ($car['fuel_type'] == 'CNG') ? 'selected' : '' ?>>CNG</option>
                    <option value="Electric" <?= ($car['fuel_type'] == 'Electric') ? 'selected' : '' ?>>Electric</option>
                </select>
            </div>


            <!-- Transmission -->
            <div class="col-md-6 mb-3">
                <label class="form-label"><i class="fa fa-cogs"></i> Transmission</label>
                <select name="transmission" class="form-select">
                    <option value="Manual" <?= $car['transmission'] == 'Manual' ? 'selected' : '' ?>>Manual</option>
                    <option value="Automatic" <?= $car['transmission'] == 'Automatic' ? 'selected' : '' ?>>Automatic</option>
                </select>
            </div>

            <!-- Mileage -->
            <div class="col-md-6 mb-3">
                <label for="mileage" class="form-label">Mileage</label>
                <input type="number" class="form-control" name="mileage" value="<?= $car['mileage'] ?>" required>
            </div>

            <!-- No of owners -->
            <div class="col-md-6 mb-3">
                <label for="number_of_owners" class="form-label">Number of Owners</label>
                <input type="number" class="form-control" name="number_of_owners" value="<?= $car['number_of_owners'] ?>" required>
            </div>

            <!-- Tags -->
            <div class="col-md-6 mb-3">
                <label for="tags" class="form-label">Tags</label>
                <input type="text" class="form-control" name="tags" value="<?= htmlspecialchars($car['tags']) ?>">
            </div>

            <!-- Car Details -->
            <?php
            // Fetch manufacturers
            $manufacturerQuery = "SELECT id, brand_name FROM car_brands";
            $manufacturerResult = $conn->query($manufacturerQuery);

            // Fetch models
            $modelsQuery = "SELECT cm.id, cm.model_name, cm.brand_id FROM car_models cm";
            $modelsResult = $conn->query($modelsQuery);
            $models = [];
            while ($row = $modelsResult->fetch_assoc()) {
                $models[] = $row;
            }

            // Fetch variants
            $variantsQuery = "SELECT cv.id, cv.variant_name, cv.model_id FROM car_variants cv";
            $variantsResult = $conn->query($variantsQuery);
            $variants = [];
            while ($row = $variantsResult->fetch_assoc()) {
                $variants[] = $row;
            }
            ?>
            <div class="col-md-6 mb-3">
                <label class="form-label" for="manufacturer">Car Brand</label>
                <select class="form-select" name="manufacturer" id="manufacturer">
                    <option disabled>Select Brand</option>
                    <?php
                    while ($row = $manufacturerResult->fetch_assoc()) {
                        $selected = ($car['car_brand'] == $row['id']) ? 'selected' : '';
                        echo "<option value='" . htmlspecialchars($row['id']) . "' $selected>" . htmlspecialchars($row['brand_name']) . "</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Car Model Dropdown -->
            <div class="col-md-6 mb-3">
                <label class="form-label" for="model">Car Model</label>
                <select class="form-select" name="model" id="model">
                    <option disabled>Select Model</option>
                    <?php
                    foreach ($models as $model) {
                        if ($model['brand_id'] == $car['car_brand']) {
                            $selected = ($car['car_model'] == $model['id']) ? 'selected' : '';
                            echo "<option value='" . htmlspecialchars($model['id']) . "' $selected>" . htmlspecialchars($model['model_name']) . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <!-- Car Variant Dropdown -->
            <div class="col-md-6 mb-3">
                <label class="form-label" for="variant">Car Variant</label>
                <select class="form-select" name="variant" id="variant">
                    <option disabled>Select Variant</option>
                    <?php
                    foreach ($variants as $variant) {
                        if ($variant['model_id'] == $car['car_model']) {
                            $selected = ($car['car_variant'] == $variant['id']) ? 'selected' : '';
                            echo "<option value='" . htmlspecialchars($variant['id']) . "' $selected>" . htmlspecialchars($variant['variant_name']) . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const models = JSON.parse(document.getElementById("modelsData").textContent);
                    const variants = JSON.parse(document.getElementById("variantsData").textContent);

                    let manufacturerDropdown = document.getElementById("manufacturer");
                    let modelDropdown = document.getElementById("model");
                    let variantDropdown = document.getElementById("variant");

                    manufacturerDropdown.addEventListener("change", function() {
                        let manufacturerId = this.value;
                        modelDropdown.innerHTML = '<option disabled>Select Model</option>';
                        variantDropdown.innerHTML = '<option disabled>Select Variant</option>';

                        models.filter(m => m.brand_id == manufacturerId).forEach(model => {
                            let option = document.createElement("option");
                            option.value = model.id;
                            option.textContent = model.model_name;
                            modelDropdown.appendChild(option);
                        });
                    });

                    modelDropdown.addEventListener("change", function() {
                        let modelId = this.value;
                        variantDropdown.innerHTML = '<option disabled>Select Variant</option>';

                        variants.filter(v => v.model_id == modelId).forEach(variant => {
                            let option = document.createElement("option");
                            option.value = variant.id;
                            option.textContent = variant.variant_name;
                            variantDropdown.appendChild(option);
                        });
                    });
                });
            </script>


            <!-- State Dropdown -->
            <div class="col-md-6 mb-3">
                <label class="form-label"><i class="fa fa-map"></i> State</label>
                <select name="location_state" id="state" class="form-select">
                    <option selected disabled>Select State</option>
                    <?php while ($row = $stateResult->fetch_assoc()) { ?>
                        <option value="<?= $row['state_id'] ?>" <?= ($car['location_state'] == $row['state_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($row['state_name']) ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <!-- City Dropdown -->
            <div class="col-md-6 mb-3">
                <label class="form-label"><i class="fa fa-city"></i> City</label>
                <select name="location_city" id="city" class="form-select">
                    <option selected disabled>Select City</option>
                    <?php foreach ($cities as $city) { ?>
                        <option value="<?= $city['city_id'] ?>" <?= ($car['location_city'] == $city['city_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($city['city_name']) ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <!-- Pin Code -->
            <div class="col-md-6 mb-3">
                <label for="pincode" class="form-label">Pin Code</label>
                <input type="text" class="form-control" name="pincode" value="<?= htmlspecialchars($car['location_pin_code']) ?>">
            </div>

            <!-- Car Image -->
            <div class="col-md-6 mb-3">
                <label class="form-label"><i class="fa fa-image"></i> Car Image</label>
                <input type="file" name="product_image" class="form-control">
                <img src="<?= htmlspecialchars($car['product_image']) ?>" class="img-thumbnail mt-2" style="width: 150px;">
            </div>

            <!-- Submit Button -->
            <div class="col-12">
                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Update Car</button>
                <a href="list.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>
    </form>
</div>

<script>
    document.getElementById("state").addEventListener("change", function() {
        let stateId = this.value;
        let cityDropdown = document.getElementById("city");
        cityDropdown.innerHTML = '<option selected disabled>Loading...</option>';

        fetch("get_cities.php?state_id=" + stateId)
            .then(response => response.json())
            .then(data => {
                cityDropdown.innerHTML = '<option selected disabled>Select City</option>';
                data.forEach(city => {
                    let option = document.createElement("option");
                    option.value = city.city_id;
                    option.textContent = city.city_name;
                    cityDropdown.appendChild(option);
                });
            });
    });
</script>

<?php include '../includes/footer.php'; ?>