<div class="container-fluid mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/car-express/public/home" style="text-decoration:none;">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
        </ol>
    </nav>

    <div>
        <?php
        // Get user ID from cookies
        $userId = isset($_GET['user_id']) ? intval($_GET['user_id']) : 9876543210;

        if ($user_id) {
            // Prepare and execute the query to get product IDs from the wishlist
            $stmt = $conn->prepare("SELECT product_id FROM wishlist WHERE user_id = $userId");
            // $stmt->bind_param("s", $user_id); // Bind user_id to the query
            $stmt->execute();
            $result = $stmt->get_result();

            $product_ids = [];
            while ($row = $result->fetch_assoc()) {
                $product_ids[] = $row['product_id'];
            }

            // Check if there are any product IDs
            if (!empty($product_ids)) {
                // Convert array to comma-separated string for SQL query
                $product_ids_str = implode(',', $product_ids);

                // Fetch product details for those product IDs
                $sql = "SELECT product_id, product_image, price, created_at, product_name AS title, location AS address 
                        FROM products 
                        WHERE product_id IN ($product_ids_str)
                        ORDER BY created_at DESC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo '<div class="container-fluid mt-5">
                            <div class="row g-4">';
                    while ($row = $result->fetch_assoc()) {
                        // Calculate time ago
                        $createdAt = new DateTime($row['created_at']);
                        $now = new DateTime();
                        $diffInSeconds = $now->getTimestamp() - $createdAt->getTimestamp();
                        $timeAgo = getTimeAgo($diffInSeconds); // Function to calculate the time ago

                        // Display product card
                        ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <a href="/car-express/public/product-detail/<?php echo $row['product_id']; ?>" class="text-dark" style="text-decoration:none;">
                                <div class="card shadow-sm p-1">
                                    <div class="favorite">
                                        <i class="bi bi-heart" style="cursor: pointer;"></i>
                                    </div>
                                    <div class="d-sm-block d-md-none p-0" style="height: 10rem;">
                                        <img src="../image.jpg" class="card-img-top w-100" alt="Product Image" style="object-fit: cover; height: 100%; width: 100%;">
                                    </div>
                                    <div class="d-none d-md-block">
                                        <img src="../image.jpg" class="card-img-top" alt="Product Image">
                                    </div>

                                    <div class="card-body">
                                        <p class="price">₹<?php echo number_format($row['price']); ?></p>
                                        <p class="text-muted" style="margin-bottom:2px;"><?php echo $row['year']; ?> • <?php echo number_format($row['km']); ?> KM</p>
                                        <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                                        <div class="d-flex justify-content-between">
                                            <p class="text-muted small mb-0"><?php echo htmlspecialchars($row['address']); ?></p>
                                            <p class="listed mb-0"><?php echo $timeAgo; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php
                    }
                    echo '</div></div>';
                } else {
                    echo "<p>No products found in your wishlist.</p>";
                }
            } else {
                echo "<p>Your wishlist is empty.</p>";
            }
        } else {
            echo "<p>User not logged in.</p>";
        }

        // Function to calculate time ago
        function getTimeAgo($diffInSeconds) {
            if ($diffInSeconds < 0) return "Just now";
            if ($diffInSeconds < 60) return "$diffInSeconds second" . ($diffInSeconds > 1 ? 's' : '') . " ago";
            if ($diffInSeconds < 3600) return floor($diffInSeconds / 60) . " minute" . (floor($diffInSeconds / 60) > 1 ? 's' : '') . " ago";
            if ($diffInSeconds < 86400) return floor($diffInSeconds / 3600) . " hour" . (floor($diffInSeconds / 3600) > 1 ? 's' : '') . " ago";
            if ($diffInSeconds < 2592000) return floor($diffInSeconds / 86400) . " day" . (floor($diffInSeconds / 86400) > 1 ? 's' : '') . " ago";
            if ($diffInSeconds < 31536000) return floor($diffInSeconds / 2592000) . " month" . (floor($diffInSeconds / 2592000) > 1 ? 's' : '') . " ago";
            return floor($diffInSeconds / 31536000) . " year" . (floor($diffInSeconds / 31536000) > 1 ? 's' : '') . " ago";
        }
        ?>
    </div>
</div>
