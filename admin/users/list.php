<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../authentication/login.php");
    exit();
}

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/db.php';
?>

<?php

// Pagination setup
$limit = 10;  // Rows per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Search functionality
$search = isset($_GET['search']) ? trim($_GET['search']) : "";
$searchQuery = $search ? "WHERE username LIKE '%$search%' OR email LIKE '%$search%' OR phone_number LIKE '%$search%'" : "";

// Fetch users from the database
$sql = "SELECT * FROM users $searchQuery LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $sql);

// Count total users for pagination
$countSql = "SELECT COUNT(*) AS total FROM users $searchQuery";
$countResult = mysqli_query($conn, $countSql);
$totalRows = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalRows / $limit);
?>

<div class="container main-container">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">USER LIST</h3>
        <!-- If you want to add user from here -->
        <!-- <a href="users/add_user.php" class="btn btn-primary">+ Add User</a> -->
    </div>

    <!-- Search Bar -->
    <form method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search users by name, email, or phone number..." value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="btn btn-secondary">Search</button>
        </div>
    </form>

    <!-- Users Table -->
    <div class="table-responsive" style="overflow-y: auto; height: 50vh">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['username'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td><?= $row['phone_number'] ?></td>
                        <td>
                        <a href="user_detail.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm">
                                <i class="fa fa-eye"></i> View
                            </a>
                            <a href="<?= BASE_URL ?>users/edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
                            <a href="<?= BASE_URL ?>users/delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirmDelete('<?= htmlspecialchars($row['username']) ?>');"><i class="fa fa-trash"></i> Delete</a>
                            <script>
                                function confirmDelete(userName) {
                                    return confirm("Are you sure you want to delete this user : " + userName + "?");
                                }
                            </script>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <nav>
        <ul class="pagination justify-content-center">
            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= $search ?>">Previous</a>
            </li>

            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&search=<?= $search ?>"><?= $i ?></a>
                </li>
            <?php } ?>

            <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page + 1 ?>&search=<?= $search ?>">Next</a>
            </li>
        </ul>
    </nav>
</div>

<?php include '../includes/footer.php'; ?>