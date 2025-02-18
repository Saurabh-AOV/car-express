<?php
session_start();

// Make it dynamic
$userIdForTesting = 9876543210;
$productIdForTesting = 5;

// POST Requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Successfully uploaded images
    $uploadedFiles = [];
    $errors = [];

    // Uploading files (Image)
    if (isset($_FILES["files"])) {
        $uploadDir = "../assets/images/products/$userIdForTesting/$productIdForTesting/";
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $files = $_FILES["files"];

        for ($i = 0; $i < count($files["name"]); $i++) {
            $fileName = basename($files["name"][$i]);
            $filePath = $uploadDir . $fileName;
            $fileSize = $files["size"][$i];
            $fileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

            // File validation
            if ($fileType !== "jpg" && $fileType !== "jpeg") {
                $errors[] = "$fileName - Only JPG files are allowed.";
                continue;
            }
            // if ($fileSize < 100 * 1024 || $fileSize > 500 * 1024) {
            //     $errors[] = "$fileName - File size must be between 100KB and 500KB.";
            //     continue;
            // }

            if (move_uploaded_file($files["tmp_name"][$i], $filePath)) {
                $uploadedFiles[] = $filePath;
            } else {
                $errors[] = "$fileName - Upload failed.";
            }
        }

        $_SESSION ["uploadedFiles"] = $uploadedFiles;
    } else if (isset($_POST['submit_product'])) {
        // Get and sanitize input values
        $manufacturer = isset($_POST['manufacturer']) ? $_POST['manufacturer'] : null;
        $model = isset($_POST['model']) ? $_POST['model'] : null;
        $variant = isset($_POST['variant']) ? $_POST['variant'] : null;
        $year_of_registration = isset($_POST['year']) ? (int)$_POST['year'] : null;
        $fuel_type = isset($_POST['fuel']) ? $_POST['fuel'] : null;
        $transmission = isset($_POST['transmission']) ? $_POST['transmission'] : null;
        $condition = isset($_POST['condition']) ? $_POST['condition'] : null;
        $mileage = isset($_POST['mileage']) ? (float)$_POST['mileage'] : null;
        $price = isset($_POST['price']) ? (float)$_POST['price'] : null;
        $state = isset($_POST['state']) ? $_POST['state'] : null;
        $city = isset($_POST['city']) ? $_POST['city'] : null;
        $pincode = isset($_POST['pincode']) ? $_POST['pincode'] : null;
        $owners = isset($_POST['owners']) ? $_POST['owners'] : null;
        $tags = isset($_POST['tags']) ? $_POST['tags'] : null;
        $title = isset($_POST['title']) ? $_POST['title'] : null;
        $description = isset($_POST['description']) ? $_POST['description'] : null;
        $images = isset($_SESSION['uploadedFiles']) && !empty($_SESSION['uploadedFiles']) 
          ? implode(",", $_SESSION['uploadedFiles']) 
          : null;


        // Here you can now use these variables in your SQL INSERT query

        // **Use Prepared Statement to Prevent SQL Injection**
        $sql = "INSERT INTO products 
            (user_id, product_name, price, description, product_condition, product_image, year_of_registration, fuel_type, transmission, mileage, number_of_owners, 
            tags, car_brand, car_model, car_variant, location_city, location_state, location_pin_code)
            VALUES 
            ($userIdForTesting, '$title', $price,'$description', '$condition', '$images',  $year_of_registration,  '$fuel_type',  '$transmission', $mileage, $owners , 
            '$tags', $manufacturer, $model, $variant, $city, $state,  $pincode)";

        if ($conn->query($sql) === TRUE) {            
            // Clear session images after successful upload
            // unset($_SESSION['uploadedFiles']);

            // Alert message
            echo "<script>alert('Product uploaded successfully!');</script>";

            exit;
        } else {
            echo "<script type='text/javascript'>
                alert('Error: " . $sql . " - " . $conn->error . "');
              </script>";
        }
    }

    echo implode(",", $uploadedFiles);
}
?>

<div class="container-fluid">
    <div class="p-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/car-express/public/home" style="text-decoration: none;">Home</a></li>
                <li class="breadcrumb-item"><a href="/car-express/public/profile" style="text-decoration: none;">Product list</a></li>
                <li class="breadcrumb-item"><a href="#" style="text-decoration: none;">Upload Product</a></li>
            </ol>
        </nav>

        <!-- Product image upload -->
        <div class="container-fluid mt-4">
            <!-- File uploading -->
            <h2 class="text-left mb-3" title="should be jpeg">Upload product image</h2>
            <form id="uploadForm" method="post" enctype="multipart/form-data">
                <div class="upload-box" id="drop-area">
                    <p class="text-center">Drag & Drop images here or
                        <label for="fileInput" class="upload-label">Click to Upload</label>
                    </p>
                    <input type="file" id="fileInput" class="file-input" name="files[]" accept="image/jpeg" multiple>
                </div>

                <div class="preview-container">
                    <div class="preview" id="preview"></div>
                </div>

                <button type="submit" class="btn btn-primary w-100 mt-3">Check Photo</button>
            </form>

            <?php if (!empty($uploadedFiles)) { ?>
                <h3 class="mt-4">Uploaded Images:</h3>
                <div class="preview">
                    <?php foreach ($uploadedFiles as $file) { ?>
                        <img src="<?php echo $file; ?>" alt="Uploaded Image">
                    <?php } ?>
                </div>
            <?php } ?>

            <?php if (!empty($errors)) { ?>
                <h3 class="text-danger mt-3">Errors:</h3>
                <ul class="error">
                    <?php foreach ($errors as $error) {
                        echo "<li class='text-danger'>$error</li>";
                    } ?>
                </ul>
            <?php } ?>

            <!-- Style and Script of the image uploading -->
            <style>
                /* Upload Box */
                .upload-box {
                    border: 2px dashed #007BFF;
                    padding: 20px;
                    text-align: center;
                    cursor: pointer;
                    border-radius: 10px;
                    transition: 0.3s;
                    background-color: #f8f9fa;
                }

                .upload-box:hover {
                    border-color: green;
                }

                /* File Input */
                .file-input {
                    display: none;
                }

                .upload-label {
                    color: blue;
                    cursor: pointer;
                    font-weight: bold;
                }

                /* Preview Container */
                .preview-container {
                    display: flex;
                    justify-content: center;
                    flex-wrap: wrap;
                }

                .preview {
                    display: grid;
                    grid-template-columns: repeat(5, minmax(100px, 1fr));
                    gap: 10px;
                    margin-top: 10px;
                }

                .preview img {
                    width: 100%;
                    height: 100px;
                    object-fit: cover;
                    border-radius: 5px;
                    border: 1px solid #ddd;
                }

                /* Responsive */
                @media (max-width: 576px) {
                    .preview {
                        grid-template-columns: repeat(2, 1fr);
                    }
                }

                @media (max-width: 768px) {
                    .preview {
                        grid-template-columns: repeat(3, 1fr);
                    }
                }
            </style>

            <script>
                const dropArea = document.getElementById("drop-area");
                const fileInput = document.getElementById("fileInput");
                const preview = document.getElementById("preview");

                dropArea.addEventListener("dragover", (event) => {
                    event.preventDefault();
                    dropArea.style.borderColor = "green";
                });

                dropArea.addEventListener("dragleave", () => {
                    dropArea.style.borderColor = "#007BFF";
                });

                dropArea.addEventListener("drop", (event) => {
                    event.preventDefault();
                    dropArea.style.borderColor = "#007BFF";
                    const files = event.dataTransfer.files;
                    fileInput.files = files;
                    previewFiles(files);
                });

                fileInput.addEventListener("change", () => {
                    previewFiles(fileInput.files);
                });

                function previewFiles(files) {
                    preview.innerHTML = "";
                    for (const file of files) {
                        if (file.type === "image/jpeg") {
                            const reader = new FileReader();
                            reader.onload = (event) => {
                                const img = document.createElement("img");
                                img.src = event.target.result;
                                preview.appendChild(img);
                            };
                            reader.readAsDataURL(file);
                        }
                    }
                }
            </script>
        </div>

        <!-- Product information -->
        <form method="POST">

            <!-- Car Details -->
            <div class="container-fluid my-3">
                <div class="row g-3">

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

                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            // Parse JSON data from PHP
                            const models = JSON.parse(document.getElementById("modelsData").textContent);
                            const variants = JSON.parse(document.getElementById("variantsData").textContent);

                            document.getElementById("manufacturer").addEventListener("change", function() {
                                let manufacturerId = this.value;
                                let modelDropdown = document.getElementById("model");
                                let variantDropdown = document.getElementById("variant");

                                // Reset model and variant dropdowns
                                modelDropdown.innerHTML = '<option selected disabled>Select Model</option>';
                                variantDropdown.innerHTML = '<option selected disabled>Select Variant</option>';

                                // Filter models based on selected manufacturer
                                let filteredModels = models.filter(model => model.brand_id == manufacturerId);
                                filteredModels.forEach(model => {
                                    let option = document.createElement("option");
                                    option.value = model.id;
                                    option.textContent = model.model_name;
                                    modelDropdown.appendChild(option);
                                });
                            });

                            document.getElementById("model").addEventListener("change", function() {
                                let modelId = this.value;
                                let variantDropdown = document.getElementById("variant");

                                // Reset variant dropdown
                                variantDropdown.innerHTML = '<option selected disabled>Select Variant</option>';

                                // Filter variants based on selected model
                                let filteredVariants = variants.filter(variant => variant.model_id == modelId);
                                filteredVariants.forEach(variant => {
                                    let option = document.createElement("option");
                                    option.value = variant.id;
                                    option.textContent = variant.variant_name;
                                    variantDropdown.appendChild(option);
                                });
                            });
                        });
                    </script>

                    <!-- Manufacturer Dropdown -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <label class="form-label" for="manufacturer">Car brand</label>
                        <select class="form-select" name="manufacturer" id="manufacturer">
                            <option selected disabled>Select Brand</option>
                            <?php
                            while ($row = $manufacturerResult->fetch_assoc()) {
                                echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['brand_name']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Car Model Dropdown -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <label class="form-label" for="model">Car Model</label>
                        <select class="form-select" name="model" id="model">
                            <option selected disabled>Select Model</option>
                        </select>
                    </div>

                    <!-- Car Variant Dropdown -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <label class="form-label" for="variant">Car Variant</label>
                        <select class="form-select" name="variant" id="variant">
                            <option selected disabled>Select Variant</option>
                        </select>
                    </div>

                    <!-- Hidden JSON Data -->
                    <script type="application/json" id="modelsData">
                        <?= json_encode($models) ?>
                    </script>
                    <script type="application/json" id="variantsData">
                        <?= json_encode($variants) ?>
                    </script>
                </div>
            </div>

            <!-- Other detail of car -->
            <div class="container-fluid">
                <div class="row g-3">
                    <!-- Year of Registration -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <label for="year" class="form-label">Year of Registration:</label>
                        <input type="number" id="year" name="year" class="form-control" min="1900" max="" value="2025">
                        <script>
                            document.getElementById("year").max = new Date().getFullYear(); // Set max year dynamically
                        </script>
                    </div>

                    <!-- Fuel Type -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <label for="fuel" class="form-label">Fuel Type:</label>
                        <select id="fuel" name="fuel" class="form-select">
                            <option value="Petrol">Petrol</option>
                            <option value="Diesel">Diesel</option>
                            <option value="CNG">CNG</option>
                            <option value="Electric">Electric</option>
                        </select>
                    </div>

                    <!-- Transmission Type -->
                    <div class="col-12 col-md-4">
                        <label class="form-label">Transmission Type:</label>
                        <div class="d-flex">
                            <div class="form-check me-3">
                                <input class="form-check-input" type="radio" name="transmission" id="manual" value="Manual">
                                <label class="form-check-label" for="manual">Manual</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="transmission" id="automatic" value="Automatic">
                                <label class="form-check-label" for="automatic">Automatic</label>
                            </div>
                        </div>
                    </div>

                    <!-- Condition -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <label for="condition" class="form-label">Condition:</label>
                        <select id="condition" name="condition" class="form-select">
                            <option value="New">New</option>
                            <option value="Used">Used</option>
                            <option value="Certified Pre-Owned">Certified Pre-Owned</option>
                        </select>
                    </div>

                    <!-- Mileage -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <label for="mileage" class="form-label">Mileage (km per liter):</label>
                        <input type="number" id="mileage" name="mileage" class="form-control" step="0.1" min="0" required>
                    </div>

                    <!-- Price -->
                    <div class="col-12 col-md-4">
                        <label for="price" class="form-label">Price (INR):</label>
                        <input type="number" id="price" name="price" class="form-control" min="0" required>
                    </div>







                    <!-- User location -->
                    <?php
                    // Fetch states from the 'location_state' table
                    $sql = "SELECT DISTINCT state_id, state_name FROM location_state";
                    $stateResult = $conn->query($sql);

                    // Fetch cities with their corresponding state_id
                    $sql = "SELECT city_id, city_name, state_id FROM location_city";
                    $cityResult = $conn->query($sql);
                    $cities = [];
                    while ($row = $cityResult->fetch_assoc()) {
                        $cities[] = $row;
                    }
                    ?>

                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            // Parse JSON data from PHP
                            const cities = JSON.parse(document.getElementById("city-data").textContent);

                            document.getElementById("state").addEventListener("change", function() {
                                let stateId = this.value;
                                let cityDropdown = document.getElementById("city");

                                // Reset city dropdown
                                cityDropdown.innerHTML = '<option selected disabled>Select City</option>';

                                // Filter cities based on selected state
                                let filteredCities = cities.filter(city => city.state_id == stateId);
                                filteredCities.forEach(city => {
                                    let option = document.createElement("option");
                                    option.value = city.city_id;
                                    option.textContent = city.city_name;
                                    cityDropdown.appendChild(option);
                                });
                            });
                        });
                    </script>

                    <!-- State Dropdown -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <label class="form-label" for="state">State Name</label>
                        <select class="form-select" name="state" id="state">
                            <option selected disabled>Select State</option>
                            <?php
                            while ($row = $stateResult->fetch_assoc()) {
                                echo "<option value='" . htmlspecialchars($row['state_id']) . "'>" . htmlspecialchars($row['state_name']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- City Dropdown -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <label class="form-label" for="city">Select City</label>
                        <select class="form-select" name="city" id="city">
                            <option selected disabled>Select City</option>
                        </select>
                    </div>

                    <!-- Hidden JSON Data (Updated ID to "city-data") -->
                    <script type="application/json" id="city-data">
                        <?= json_encode($cities) ?>
                    </script>

                    <!-- Pincode -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <label for="pincode" class="form-label">Pincode:</label>
                        <input type="tel" id="pincode" name="pincode" class="form-control" pattern="\d{6}" maxlength="6" required>
                        <!-- <small class="form-text text-muted">Enter a 6-digit pincode</small> -->
                    </div>






















                    <!-- <div>
                    <style>
                        .box {
                            border: 1px solid #000;
                            position: relative;
                            padding: 20px;
                            margin: 50px auto;
                        }

                        .box::before {
                            content: '';
                            position: absolute;
                            top: -2px;
                            left: 0;
                            right: 0;
                            height: 1px;
                            z-index: 1;
                        }

                        .box .heading {
                            position: absolute;
                            top: -14px;
                            left: 10%;
                            background-color: #fff;
                            padding: 0 10px;
                            z-index: 2;
                        }
                    </style>
                    <div class="box form-control">
                        <div class="heading">Your Heading</div>
                        <p>This is some content inside the box.</p>
                    </div>
                    </div> -->


                    <!-- Number of Owners -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <label for="owners" class="form-label">Number of Owners:</label>
                        <select id="owners" name="owners" class="form-select">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="5+">5+</option>
                        </select>
                    </div>

                    <!-- Tags -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <label for="tags" class="form-label">Tags (comma separated):</label>
                        <input type="text" id="tags" name="tags" class="form-control">
                    </div>




                    <!-- Title -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <label for="title" class="form-label">Title:</label>
                        <input type="text" id="title" name="title" class="form-control" required>
                    </div>

                    <!-- Description -->
                    <div class="col-12">
                        <label for="description" class="form-label">Description:</label>
                        <textarea id="description" name="description" class="form-control" rows="5" required></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12">
                        <button type="submit" name="submit_product" class="btn btn-primary w-100">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>