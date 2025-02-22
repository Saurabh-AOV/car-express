<?php
// ob_start(); // Start output buffering
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../../authentication/login.php");
    exit();
}
include '../../includes/header.php';
include '../../includes/sidebar.php';
include '../../includes/db.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_city'])) {
    $state_id = intval($_POST['state_id']);
    $city_name = trim($_POST['city_name']);

    if (empty($state_id) || empty($city_name)) {
        $_SESSION['error'] = "State and City name are required!";
    } else {
        // Check if the city already exists for the given state
        $checkQuery = "SELECT * FROM location_city WHERE city_name = ? AND state_id = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("si", $city_name, $state_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['error'] = "City already exists in this state!";
        } else {
            // Insert new city
            $insertQuery = "INSERT INTO location_city (state_id, city_name) VALUES (?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("is", $state_id, $city_name);
            if ($stmt->execute()) {
                $_SESSION['success'] = "City added successfully!";
            } else {
                $_SESSION['error'] = "Failed to add city!";
            }
        }
    }
    header("Location: city.php"); // Redirect back to the form page
    exit();
}

// Search functionality
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Pagination settings
$limit = 10; // Number of records per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Fetch states with search & pagination
$stateQuery = "SELECT * FROM location_state WHERE state_name LIKE ? ORDER BY state_id DESC LIMIT ?, ?";
$stmt = $conn->prepare($stateQuery);
$searchParam = "%$search%";
$stmt->bind_param("sii", $searchParam, $offset, $limit);
$stmt->execute();
$stateResult = $stmt->get_result();

// Get total records for pagination
$totalQuery = "SELECT COUNT(*) AS total FROM location_state WHERE state_name LIKE ?";
$stmt = $conn->prepare($totalQuery);
$stmt->bind_param("s", $searchParam);
$stmt->execute();
$totalResult = $stmt->get_result();
$totalRow = $totalResult->fetch_assoc();
$totalRecords = $totalRow['total'];
$totalPages = ceil($totalRecords / $limit);



// Fetch states
$stateQuery = "SELECT * FROM location_state";
$stateResult = $conn->query($stateQuery);
$states = [];
while ($row = $stateResult->fetch_assoc()) {
    $states[$row['state_id']] = $row['state_name'];
}

// Search functionality
$search = isset($_GET['search']) ? trim($_GET['search']) : "";

// Fetch cities with state names
$cityQuery = "SELECT * FROM location_city WHERE city_name LIKE '%$search%' OR state_id IN (SELECT state_id FROM location_state WHERE state_name LIKE '%$search%')";
$cityResult = $conn->query($cityQuery);
?>

<div class="container main-container">
    <div class="row">
        <!-- Left Side: Table -->
        <div class="col-md-8">
            <div class="card p-3">
                <h4 class="fw-bold mb-3">City List</h4>

                <!-- Success & Error Messages -->
                <?php if (isset($_SESSION['success'])) { ?>
                    <div class="alert alert-success"><?= $_SESSION['success'];
                                                        unset($_SESSION['success']); ?></div>
                <?php } ?>
                <?php if (isset($_SESSION['error'])) { ?>
                    <div class="alert alert-danger"><?= $_SESSION['error'];
                                                    unset($_SESSION['error']); ?></div>
                <?php } ?>

                <!-- Search Form -->
                <form method="GET" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search by City Name, State Name..." value="<?= htmlspecialchars($search) ?>">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                    </div>
                </form>

                <!-- State Table -->
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>S No</th>
                            <th>State Name</th>
                            <th>City Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sno = 1;
                        while ($row = $cityResult->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $sno++ ?></td>
                                <td><?= htmlspecialchars($states[$row['state_id']] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($row['city_name']) ?></td>
                                <td>
                                    <a href="edit-city.php?id=<?= $row['city_id'] ?>" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <a href="delete-city.php?id=<?= $row['city_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirmDelete('<?= htmlspecialchars($row['city_name']) ?>');">
                                        <i class="fa fa-trash"></i> Delete
                                    </a>
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

                <!-- Pagination -->
                <nav>
                    <ul class="pagination justify-content-center">
                        <!-- Previous button -->
                        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>">Previous</a>
                        </li>

                        <?php
                        $range = 2;
                        $startPage = max(1, $page - $range);
                        $endPage = min($totalPages, $page + $range);

                        if ($startPage > 1) {
                            echo '<li class="page-item"><a class="page-link" href="?page=1&search=' . urlencode($search) . '">1</a></li>';
                            if ($startPage > 2) {
                                echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            }
                        }

                        for ($i = $startPage; $i <= $endPage; $i++) {
                            echo '<li class="page-item ' . ($page == $i ? 'active' : '') . '">
                                    <a class="page-link" href="?page=' . $i . '&search=' . urlencode($search) . '">' . $i . '</a>
                                  </li>';
                        }

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
            </div>
        </div>

        <!-- Right Side: Add New City -->
        <div class="col-md-4">
            <div class="card shadow-lg p-4">
                <h4 class="fw-bold text-primary text-center">Add New City</h4>
                <form action="add-city.php" method="POST">
                    <!-- Dropdown for State Selection -->
                    <div class="mb-3">
                        <label for="state_id" class="form-label fw-bold">Select State</label>
                        <select class="form-control" name="state_id" required>
                            <option value="">-- Select State --</option>
                            <?php
                            // Fetch states from the database
                            $stateQuery = "SELECT * FROM location_state ORDER BY state_name ASC";
                            $stateResult = $conn->query($stateQuery);
                            while ($state = $stateResult->fetch_assoc()) {
                                echo "<option value='{$state['state_id']}'>" . htmlspecialchars($state['state_name']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- City Name Input -->
                    <div class="mb-3">
                        <label for="city_name" class="form-label fw-bold">City Name</label>
                        <input type="text" class="form-control" name="city_name" required>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary px-4" name="add_city">Add City</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<?php include '../../includes/footer.php'; ?>