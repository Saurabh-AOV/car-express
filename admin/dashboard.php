<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: authentication/login.php");
    exit();
}

include 'includes/header.php';
include 'includes/sidebar.php';
?>

<div class="my-3">
    <h2>Admin Dashboard</h2>
    <p>Welcome, <?php echo $_SESSION['admin_name']; ?>!</p>

    <div>
        <p>Total Users: 100</p>
        <p>Total Cars Listed: 50</p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>