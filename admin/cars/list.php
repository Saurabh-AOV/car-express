<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../authentication/login.php");
    exit();
}

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/db.php'; // Database connection

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Search filter
$search = isset($_GET['search']) ? trim($_GET['search']) : "";
$userId = isset($_GET['user_id']) ? trim($_GET['user_id']) : "";


// Query conditions
$searchCondition = " WHERE 1=1 ";
if (!empty($search)) {
    $searchCondition .= " AND product_name LIKE '%" . $conn->real_escape_string($search) . "%' ";
}
if (!empty($userId)) {
    $searchCondition .= " AND user_id = '" . $conn->real_escape_string($userId) . "' ";
}

// Fetch total count for pagination
$totalQuery = "SELECT COUNT(*) as total FROM products $searchCondition";
$totalResult = $conn->query($totalQuery);
$totalRow = $totalResult->fetch_assoc();
$totalCars = $totalRow['total'];
$totalPages = ceil($totalCars / $limit);

// Fetch car listings
$sql = "SELECT * FROM products 
        $searchCondition
        ORDER BY created_at DESC 
        LIMIT $limit OFFSET $offset";

$result = $conn->query($sql);
?>

<div class="container main-container">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3><i class="fa fa-car"></i> Car Listings</h3>
        <a href="add_car.php" class="btn btn-primary"><i class="fa fa-plus"></i> Add Car</a>
    </div>

    <!-- Search Form -->
    <form method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by Name, Brand, Model..." value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="btn btn-secondary"><i class="fa fa-search"></i> Search</button>
        </div>
    </form>

    <?php if ($result->num_rows > 0) { ?>
        <!-- Cars Table -->
        <div class="table-responsive" style="max-height: 358px; overflow-y: auto;">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th title="Listing Id">ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Brand</th>
                        <th>Year</th>
                        <th>Price</th>
                        <th>Fuel Type</th>
                        <th>No. of Owners</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $row['product_id'] ?></td>
                            <td>
                                <?php
                                // Check if product_image exists and is not empty
                                $imagePaths = !empty($row['product_image']) ? explode(',', $row['product_image']) : [];
                                $firstImage = !empty($imagePaths) ? trim($imagePaths[0]) : '../assets/images/default-car.jpg'; // Fallback image
                                ?>

                                <img src="<?= htmlspecialchars($firstImage) ?>" class="img-thumbnail" style="width: 80px; height: 50px; object-fit: cover;">

                            </td>
                            <td><?= strlen($row['product_name']) > 15 ? htmlspecialchars(substr($row['product_name'], 0, 15)) . '...' : htmlspecialchars($row['product_name']) ?></td>
                            <td><?= htmlspecialchars($row['car_brand']) ?></td>
                            <td><?= htmlspecialchars($row['year_of_registration']) ?></td>
                            <td>₹<?= number_format($row['price']) ?></td>
                            <td><?= htmlspecialchars($row['fuel_type'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($row['number_of_owners'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($row['location_city'] ?? 'N/A') ?></td>
                            <td>
                                <span class="badge bg-<?= $row['status'] == 'Active' ? 'success' : ($row['status'] == 'Pending' ? 'warning' : 'danger') ?>">
                                    <?= $row['status'] ?>
                                </span>
                            </td>
                            <td>
                            <a href="edit.php?user_id=<?= $row['user_id'] ?>&id=<?= $row['product_id'] ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>

                                <a href="delete.php?id=<?= $row['product_id'] ?>" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete product ID : <?= $row['product_id'] ?>?')">
                                    <i class="fa fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav>
            <ul class="pagination justify-content-center">
                <!-- Previous button -->
                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>">Previous</a>
                </li>

                <?php
                // Define the range of pages to display
                $range = 2; // Number of pages to show around the current page
                $startPage = max(1, $page - $range); // Start page (can't go below 1)
                $endPage = min($totalPages, $page + $range); // End page (can't exceed total pages)

                // Display "First" page button if needed
                if ($startPage > 1) {
                    echo '<li class="page-item"><a class="page-link" href="?page=1&search=' . urlencode($search) . '">1</a></li>';
                    if ($startPage > 2) {
                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                    }
                }

                // Display page links within the range
                for ($i = $startPage; $i <= $endPage; $i++) {
                    echo '<li class="page-item ' . ($page == $i ? 'active' : '') . '">
                    <a class="page-link" href="?page=' . $i . '&search=' . urlencode($search) . '">' . $i . '</a>
                  </li>';
                }

                // Display "Last" page button if needed
                if ($endPage < $totalPages) {
                    if ($endPage < $totalPages - 1) {
                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                    }
                    echo '<li class="page-item"><a class="page-link" href="?page=' . $totalPages . '&search=' . urlencode($search) . '">' . $totalPages . '</a></li>';
                }
                ?>

                <!-- Next button -->
                <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>">Next</a>
                </li>
            </ul>
        </nav>


    <?php } else { ?>
        <div class="alert alert-warning text-center mt-4">
            <i class="fa fa-exclamation-circle"></i> <strong>No Listings Available</strong>
        </div>
    <?php } ?>
</div>

<?php include '../includes/footer.php'; ?>