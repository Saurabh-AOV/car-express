<?php
ob_start(); // Start output buffering
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../authentication/login.php");
    exit();
}

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/db.php';

$message = ""; // Initialize message variable

// Handle add request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $code = trim($_POST['language_code']);
    $name = trim($_POST['language_name']);

    if (!empty($code) && !empty($name)) {
        $stmt = $conn->prepare("INSERT INTO languages (language_code, language_name) VALUES (?, ?)");
        $stmt->bind_param("ss", $code, $name);

        if ($stmt->execute()) {
            $message = "<div class='alert alert-success'>Language added successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error adding language: " . $conn->error . "</div>";
        }

        $stmt->close();
    } else {
        $message = "<div class='alert alert-warning'>All fields are required!</div>";
    }
}
?>

<div class="container main-container">
    <h3 class="mt-4">Add Language</h3>

    <!-- Display success or error message -->
    <?= $message ?>

    <div class="row">
        <div class="col-md-8">
            <form method="post" class="mb-4">
                <div class="mb-3">
                    <label class="form-label">Language Code</label>
                    <input type="text" name="language_code" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Language Name</label>
                    <input type="text" name="language_name" class="form-control" required>
                </div>
                <button type="submit" name="add" class="btn btn-primary">Add Language</button>
                <a href="list.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
