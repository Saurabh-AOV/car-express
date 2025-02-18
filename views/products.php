<nav aria-label="breadcrumb">
        <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/car-express/public/home" style="text-decoration:none;">Home</a>
                </li>
                <li class="breadcrumb-item"><a href="/car-express/public/products"
                                style="text-decoration:none;">Product</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo ucfirst($_GET['location']); ?></li>
        </ol>
</nav>

<?php
$location = $_GET["location"];

if ($location) {
        // Find city_id or state_id based on the location name
        $locationIdQuery = "
            SELECT city_id AS location_id FROM location_city WHERE city_name = '$location'
            UNION
            SELECT state_id FROM location_state WHERE state_name = '$location'
        ";

        $locationIdResult = $conn->query($locationIdQuery);

        if ($locationIdResult && $locationIdResult->num_rows > 0) {
                $row = $locationIdResult->fetch_assoc();
                $locationId = $row["location_id"];

                // Fetch products based on the found location_id
                $query = "
                SELECT 
                    product_id, 
                    product_image, 
                    price, 
                    created_at, 
                    product_name AS title, 
                    COALESCE(location_city, location_state) AS address
                FROM 
                    products 
                WHERE 
                    location_city = '$locationId' OR location_state = '$locationId'
                ORDER BY 
                    created_at DESC
            ";
        } else {
                // If locationId not found, return all products
                $query = "
                SELECT 
                    product_id, product_image, price, created_at, 
                    product_name AS title, location_city AS address 
                FROM products
                ORDER BY created_at DESC
            ";
        }
} else {
        // No location provided, return all products
        $query = "
            SELECT 
                product_id, product_image, price, created_at, 
                product_name AS title, location_city AS address 
            FROM products
            ORDER BY created_at DESC
        ";
}

require_once __DIR__ . '/sections/productCard.php';