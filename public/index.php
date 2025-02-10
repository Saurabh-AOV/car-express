<?php
// Enable error reporting for debugging (Turn off in production)
error_reporting(E_ALL);  
ini_set('display_errors', 'Off'); 
ini_set('log_errors', 'On'); 
ini_set('error_log', '../logs/error_log_file.log'); 

// Load application configuration
require_once __DIR__ . '/../config/db.php';

// Include header
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/navBar.php';
?>

<div class="main-container">

<?php
require_once __DIR__ . '/../routes/web.php';
?>

</div>

<!-- Include footer -->
<?php require_once __DIR__ . '/../templates/footer.php'; ?>