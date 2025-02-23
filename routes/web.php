<?php
// Start session if needed
session_start();

// Get the request URI and clean it
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request = str_replace('/car-express/public', '', $request); // Adjust for subfolder if needed
$request = rtrim($request, '/'); // Remove trailing slash

// Define routes
$routes = [
    '/'               => '../views/home.php',
    '/home'           => '../views/home.php',
    '/wishlist'       => '../views/wishlist.php',
    '/chat'           => '../views/chat.php',
    '/product-detail' => '../views/product-details.php',
    '/profile'        => '../views/user-profile.php',
    '/sell'           => '../views/sell.php',
    '/products'       => '../views/products.php',
    '/logout'       => '../views/logout.php'
];

// If route exists, include the corresponding file
if (array_key_exists($request, $routes)) {
    require_once __DIR__ . '/' . $routes[$request];
} else {
    // Handle dynamic product-detail route with ID parameter
    if (preg_match('#^/product-detail/(\d+)$#', $request, $matches)) {
        $productId = $matches[1]; // Capture the ID from the URL
        // Dynamically include the product-details page and pass the productId
        include_once __DIR__ . '/../views/product-details.php';
        // You can now access $productId in product-details.php
    } else {
        // Handle 404 if no match
        http_response_code(404);
        include_once __DIR__ . '/../views/404.php';
    }
}
