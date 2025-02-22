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

// Handle update request
if (isset($_POST['update'])) {
    $id = $_POST['language_id'];
    $code = $_POST['language_code'];
    $name = $_POST['language_name'];
    $sql = "UPDATE languages SET language_code='$code', language_name='$name' WHERE language_id=$id";
    
    if ($conn->query($sql) === TRUE) {
        // Set a session message or a URL parameter for success
        $_SESSION['update_success'] = "Language updated successfully!";
        header("Location: list.php");
        exit();
    } else {
        $_SESSION['update_error'] = "Error updating language!";
    }
}

// Fetch language to edit
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM languages WHERE language_id = $id");
    $language = $result->fetch_assoc();
} else {
    header("Location: list.php");
    exit();
}
?>

<div class="container main-container">
    <h3 class="mt-4">Edit Language</h3>
    <div class="row">
        <div class="col-md-8">
            <form method="post" class="mb-4">
                <input type="hidden" name="language_id" value="<?= $language['language_id'] ?>">
                <div class="mb-3">
                    <label class="form-label">Language Code</label>
                    <input type="text" name="language_code" value="<?= htmlspecialchars($language['language_code']) ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Language Name</label>
                    <input type="text" name="language_name" value="<?= htmlspecialchars($language['language_name']) ?>" class="form-control" required>
                </div>
                <button type="submit" name="update" class="btn btn-primary">Update</button>
                <a href="list.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Previous Information</h5>
                    <ul class="list-group">
                        <li class="list-group-item"><strong>ID:</strong> <?= $language['language_id'] ?></li>
                        <li class="list-group-item"><strong>Language Code:</strong> <?= htmlspecialchars($language['language_code']) ?></li>
                        <li class="list-group-item"><strong>Language Name:</strong> <?= htmlspecialchars($language['language_name']) ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
