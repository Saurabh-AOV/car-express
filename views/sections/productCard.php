<?php

// 1️⃣ **Fetch all city names in advance**
$cityQuery = "SELECT city_id, city_name FROM location_city";
$cityResult = $conn->query($cityQuery);

$cityNames = [];
while ($cityRow = $cityResult->fetch_assoc()) {
    $cityNames[$cityRow['city_id']] = ucwords(htmlspecialchars($cityRow['city_name']));
}


// Fetch Products with a query
$sql = isset($query) ? $query : "SELECT product_id, product_image, price, created_at, product_name AS title, location AS address 
        FROM products 
        ORDER BY created_at DESC";

$result = $conn->query($sql);
?>


<div class="container-fluid mx-0 mx-md-3">
    <div class="row g-4">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <?php
                $createdAt = new DateTime($row['created_at']);
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

                // 3️⃣ **Get City Name from preloaded array**
                $city_id = (int) $row['address'];
                $city_name = isset($cityNames[$city_id]) ? $cityNames[$city_id] : "Unknown City";


                ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">

                    <a href="/car-express/public/product-detail?listing=<?php echo $row['product_id']; ?>" class="text-dark" style="text-decoration:none;">
                        <div class="card shadow-sm p-1">
                            <!-- Favorite Icon -->
                            <div class="favorite">
                                <i class="bi bi-heart" style="cursor: pointer;"></i>
                            </div>

                            <!-- Product Image -->
                            <!-- Mobile View ke liye padding remove -->
                            <div class="d-sm-block d-md-none p-0" style="height: 10rem;">
                                <img src="../image.jpg" class="card-img-top w-100" alt="Product Image" style="object-fit: cover; height: 100%; width: 100%;">
                            </div>

                            <!-- Normal padding for larger screens -->
                            <div class="d-none d-md-block">
                                <img src="../image.jpg" class="card-img-top" alt="Product Image">
                            </div>
                            <!-- <img src="../image.jpg" class="card-img-top" alt="Product Image"> -->

                            <div class="card-body">
                                <!-- Price -->
                                <p class="price">₹<?php echo number_format($row['price']); ?></p>

                                <!-- Title with Single Line & Ellipsis -->
                                <h6 class="card-title text-truncate" title="<?php echo $row['title'] ?>" style="max-width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <?php echo htmlspecialchars($row['title']); ?>
                                </h6>

                                <!-- Year & KM -->
                                <p class="text-muted" style="margin-bottom:2px;">
                                    <?php echo isset($row['year_of_registration']) ? "• " . $row['year_of_registration'] : "";  ?>
                                    <?php echo isset($row['mileage']) ? "• " . number_format($row['mileage']) . " Mileage" : "" ?>
                                </p>

                                <div class="d-flex justify-content-between">
                                    <!-- City name -->
                                    <p class="text-muted small mb-0"><?php echo $city_name; ?></p>
                                    <!-- Listing Date -->
                                    <p class="listed mb-0"><?php echo $timeAgo; ?></p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <!-- No Data Found Message -->
            <div class="col-12 text-center">
                <h4 class="text-muted">No products found</h4>
            </div>
        <?php endif; ?>
    </div>
</div>