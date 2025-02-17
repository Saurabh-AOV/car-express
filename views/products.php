<nav aria-label="breadcrumb">
        <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/car-express/public/home" style="text-decoration:none;">Home</a></li>
                <li class="breadcrumb-item"><a href="/car-express/public/products" style="text-decoration:none;">Product</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo ucfirst($_GET['location']); ?></li>
        </ol>
</nav>

<?php
$location = $_GET["location"];
$query = isset($location) ? "SELECT product_id, product_image, price, created_at, product_name AS title, location AS address 
        FROM products where location = '$location'
        ORDER BY created_at DESC" : "SELECT product_id, product_image, price, created_at, product_name AS title, location AS address 
        FROM products
        ORDER BY created_at DESC";
require_once __DIR__ . '/sections/productCard.php';
