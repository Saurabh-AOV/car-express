<?php
// Start session if needed
session_start();

// Get the request URI and clean it
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request = str_replace('/car-express/public', '', $request); // Adjust for subfolder
$request = rtrim($request, '/'); // Remove trailing slash

// Define routes
$routes = [
    '/'               => '../views/home.php',
    '/home'           => '../views/home.php',
    '/wishlist'    => '../views/wishlist.php',
    '/chat'       => '../views/chat.php',
    // '/lifepath'       => '../views/lifepath.php',
    // '/nameanalysis'   => '../views/nameanalysis.php',
    // '/personal_year'  => '../views/personal_year.php',
    // '/grid_analysis'  => '../views/grid_analysis.php',
    // '/missing_number' => '../views/missing_number.php',
    // '/remedies'       => '../views/remedies.php',
    // '/planes'         => '../views/planes.php',
    // '/generate-report'  => '../views/numerology_report.php'
];

// If route exists, include the corresponding file
if (array_key_exists($request, $routes)) {
    require_once __DIR__ . '/' . $routes[$request];
} else {
    http_response_code(404);
    require_once __DIR__ . '/../views/404.php';
}