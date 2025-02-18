<?php
$productId = $_GET['listing'];
$product = null; // Initialize product variable

// Fetch the product details from the database
if ($productId) {
    // Fetch the product data
    $sql = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Product not found.";
    }
    $stmt->close(); // Close statement but keep DB connection open
}
?>

<div class="container-fluid mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mx-3">
            <li class="breadcrumb-item"><a href="/car-express/public/home" style="text-decoration:none;">Home</a></li>
            <li class="breadcrumb-item"><a href="#" style="text-decoration:none;">Cars</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $product['product_name'] ?></li>
        </ol>
    </nav>

    <div class="product-container mx-3">
        <div class="d-flex w-100 product-detail-flex-column gap-2">

            <?php
            $createdAt = new DateTime($product['created_at']);
            $now = new DateTime();

            // Get the time difference in seconds
            $diffInSeconds = $now->getTimestamp() - $createdAt->getTimestamp();

            // Prevent negative values (for future dates)
            if ($diffInSeconds < 0) {
                $timeAgo = "Just now";
            } elseif ($diffInSeconds < 60) {
                $timeAgo = "$diffInSeconds second" . ($diffInSeconds > 1 ? 's' : '') . " ago";
            } elseif ($diffInSeconds < 3600) {
                $minutes = floor($diffInSeconds / 60);
                $timeAgo = "$minutes minute" . ($minutes > 1 ? 's' : '') . " ago";
            } elseif ($diffInSeconds < 86400) {
                $hours = floor($diffInSeconds / 3600);
                $timeAgo = "$hours hour" . ($hours > 1 ? 's' : '') . " ago";
            } elseif ($diffInSeconds < 2592000) {
                $days = floor($diffInSeconds / 86400);
                $timeAgo = "$days day" . ($days > 1 ? 's' : '') . " ago";
            } elseif ($diffInSeconds < 31536000) {
                $months = floor($diffInSeconds / 2592000);
                $timeAgo = "$months month" . ($months > 1 ? 's' : '') . " ago";
            } else {
                $years = floor($diffInSeconds / 31536000);
                $timeAgo = "$years year" . ($years > 1 ? 's' : '') . " ago";
            }



            $phone_number = $product['user_id'];
            $queryUserName = "SELECT username FROM users WHERE phone_number = '$phone_number'";

            // Execute the query
            $userNameResult = $conn->query($queryUserName);

            // Check if any result is returned
            if ($userNameResult->num_rows > 0) {
                // Fetch the result
                $rowOfUser = $userNameResult->fetch_assoc();
                $username = $rowOfUser['username'];
            }
            ?>

            <?php
            // Ensure location_state and location_city exist
            $state_id = isset($product['location_state']) ? (int) $product['location_state'] : 0;
            $city_id = isset($product['location_city']) ? (int) $product['location_city'] : 0;

            // Function to fetch names from database safely
            function getLocationName($conn, $table, $column, $id_column, $id)
            {
                if ($id === 0) return "Not available"; // Handle missing IDs

                $stmt = $conn->prepare("SELECT $column FROM $table WHERE $id_column = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                return $row ? htmlspecialchars($row[$column]) : "Not found";
            }

            // Fetch state and city names
            $state_name = getLocationName($conn, "location_state", "state_name", "state_id", $state_id);
            $city_name = getLocationName($conn, "location_city", "city_name", "city_id", $city_id);
            ?>
            <!-- <div style="width:70%;"> -->
            <div class="product-detail-left">
                <div class="product-img-section mb-4">
                    <?php
                    $imagesString = $product['product_image'];
                    require_once __DIR__ . "/sections/product-detail-content/largeScreenProductImage.php";
                    ?>
                </div>

                <div class="product-details my-1 card px-3 py-4">
                    <h2 class="mb-3">Overview</h2>
                    <hr />
                    <div class="row mb-3 g-2">
                        <div class="align-items-center col-4 d-flex align-items-start mb-3 gap-2 justify-content-center gap-4">
                            <i style="font-size: 20px;" class="bi bi-clipboard-check"></i> <!-- Transmission Icon -->
                            <div>
                                <h6 class="mb-1 text-muted">Condition</h6>
                                <h4 class="mb-0"><?php echo $product['product_condition']; ?></h4>
                            </div>
                        </div>
                        <div class="align-items-center col-4 d-flex align-items-start mb-3 gap-2 justify-content-center gap-4">
                            <i style="font-size: 20px;" class="bi bi-check-circle"></i> <!-- Transmission Icon -->
                            <div>
                                <h6 class="mb-1 text-muted">Status</h6>
                                <h4 class="mb-0"><?php echo $product['status']; ?></h4>
                            </div>
                        </div>
                        <div class="align-items-center col-4 d-flex align-items-start mb-3 gap-2  justify-content-center gap-4">
                            <i style="font-size: 20px;" class="bi bi-calendar-event"></i> <!-- Transmission Icon -->
                            <div>
                                <h6 class="mb-1 text-muted">Registration</h6>
                                <h4 class="mb-0"><?php echo $product['year_of_registration']; ?></h4>
                            </div>
                        </div>
                        <div class="align-items-center col-4 d-flex align-items-start mb-3 gap-2  justify-content-center gap-4">
                            <i style="font-size: 20px;" class="bi bi-fuel-pump-fill"></i> <!-- Transmission Icon -->
                            <div>
                                <h6 class="mb-1 text-muted">Fuel Type</h6>
                                <h4 class="mb-0"><?php echo $product['fuel_type']; ?></h4>
                            </div>
                        </div>
                        <div class="align-items-center col-4 d-flex align-items-start mb-3 gap-2  justify-content-center gap-4">
                            <i style="font-size: 20px;" class="bi bi-gear"></i> <!-- Transmission Icon -->
                            <div>
                                <h6 class="mb-1 text-muted">Transmission</h6>
                                <h4 class="mb-0"><?php echo $product['transmission']; ?></h4>
                            </div>
                        </div>
                        <div class="align-items-center col-4 d-flex align-items-start mb-3 gap-2  justify-content-center gap-4">
                            <i style="font-size: 20px;" class="bi bi-speedometer"></i>
                            <div>
                                <h6 class="mb-1 text-muted">Mileage</h6>
                                <h4 class="mb-0"><?php echo $product['mileage']; ?></h4>
                            </div>
                        </div>
                        <div class="col-4 d-flex align-items-start mb-3 gap-2  justify-content-center">
                            <i class="bi bi-person"></i> <!-- Transmission Icon -->
                            <div>
                                <h6 class="mb-1 text-muted">No of Owners</h6>
                                <h4 class="mb-0"><?php echo $product['number_of_owners']; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="product-details my-1 card px-3 py-3">
                    <h2 class=" mb-3">Description</h2>
                    <div>
                        <?php echo $product["description"] ?>
                    </div>
                </div>
            </div>

            <!-- <div style="width:30%"> -->
            <div class="product-detail-right">
                <div class="card mb-2" style=" position: relative;">

                    <!-- Price card -->
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title"> ₹ <?php echo $product['price'] ?></h5>
                            </div>
                            <div>
                                <button class="btn btn-sm mb-2" id="shareBtn"><i class="bi bi-share"></i></button>

                                <div id="shareOptions" class="mt-2" style="display: none;">
                                    <a id="whatsapp-link" href="#" class="btn btn-success btn-sm me-2" target="_blank">
                                        <i class="bi bi-whatsapp"></i> WhatsApp
                                    </a>

                                    <script>
                                        document.getElementById('whatsapp-link').href = 'https://api.whatsapp.com/send?text=' + encodeURIComponent(window.location.href);
                                    </script>


                                    <a href="mailto:?subject=Check%20this%20out&body=Here%20is%20something%20interesting!"
                                        class="btn btn-danger btn-sm">
                                        <i class="bi bi-envelope"></i> Email
                                    </a>
                                </div>

                                <script>
                                    $(document).ready(function() {
                                        $("#shareBtn").click(function() {
                                            $("#shareOptions").toggle(); // Show/Hide buttons
                                        });
                                    });
                                </script>
                                <button class="btn  btn-sm mb-2"><i class="bi bi-heart"></i></button>
                            </div>
                        </div>
                        <p><?php echo $product['product_name'] ?></p>

                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="card-subtitle mb-0 text-muted">Listed on: <?php
                                                                                    $date = $product['created_at'];
                                                                                    $formattedDate = date("M d, Y", strtotime($date));
                                                                                    echo $formattedDate; // Output: Feb 17, 2025
                                                                                    ?>
                            </h6>
                            <p class="card-text">
                                <strong><?php echo $timeAgo ?></strong>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- User profile -->
                <div class="product-details  card p-3 mb-2">
                    <div class="w-100 d-flex justify-content-between align-items-center">
                        <div class="d-flex gap-2 align-items-center">
                            <img src="../image.jpg" style="height: 4rem; width:4rem; border-radius: 50%;"
                                alt="user profile" />
                            <h5 class='mb-0'><?php echo $username ?></h5>



                        </div>
                        <i class="bi bi-arrow-right-short" style="font-size:35px;"></i>
                    </div>

                    <button class="btn btn-success mt-3">Chat with seller</button>
                </div>

                <!-- Posted in -->
                <div class="product-details  card p-3 mb-2">
                    <h4 class="mb-3">Posted in</h4>
                    <div>


                        <p><span><strong>State:</strong> <?php echo $state_name; ?></span> <span><strong>City:</strong> <?php echo $city_name; ?></span></p>
                    </div>

                </div>

                <!-- Map -->
                <div class="product-details  card p-3 mb-2">
                    <!-- Embed Google Map inside the div -->
                    <iframe width="100%" height="300"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.012745268376!2d-122.08424998468224!3d37.42199977982513!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808fbb2d6a0a0b33%3A0x38c8e6c8de7271b!2sGoogleplex!5e0!3m2!1sen!2sus!4v1676110503341!5m2!1sen!2sus"
                        frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>