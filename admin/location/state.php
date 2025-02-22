<?php
ob_start(); // Start output buffering
session_start();
include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/db.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_state'])) {
    $state_name = trim($_POST['state_name']);

    if (empty($state_name)) {
        $_SESSION['error'] = "State name is required!";
    } else {
        // Check if state already exists
        $checkQuery = "SELECT * FROM location_state WHERE state_name = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("s", $state_name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['error'] = "State already exists!";
        } else {
            // Insert new state
            $insertQuery = "INSERT INTO location_state (state_name) VALUES (?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("s", $state_name);
            if ($stmt->execute()) {
                $_SESSION['success'] = "State added successfully!";
            } else {
                $_SESSION['error'] = "Failed to add state!";
            }
        }
    }
    header("Location: ./state.php");
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
?>

<div class="container main-container">
    <div class="row">
        <!-- Left Side: Table -->
        <div class="col-md-8">
            <div class="card p-3">
                <h4 class="fw-bold mb-3">State List</h4>

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
                        <input type="text" name="search" class="form-control" placeholder="Search by State Name..." value="<?= htmlspecialchars($search) ?>">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                    </div>
                </form>

                <!-- State Table -->
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>State Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($state = $stateResult->fetch_assoc()) { ?>
                            <tr id="row-<?= $state['state_id'] ?>">
                                <td><?= htmlspecialchars($state['state_id']) ?></td>
                                <td id="state-name-<?= $state['state_id'] ?>">
                                    <span class="view-mode"><?= htmlspecialchars($state['state_name']) ?></span>
                                    <input type="text" class="edit-mode form-control" value="<?= htmlspecialchars($state['state_name']) ?>" style="display: none;">
                                </td>
                                <td>
                                    <!-- Edit Button -->
                                    <button class="btn btn-warning btn-sm edit-btn" onclick="editState(<?= $state['state_id'] ?>)">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>

                                    <!-- Update Button (Hidden Initially) -->
                                    <button class="btn btn-success btn-sm update-btn" onclick="updateState(<?= $state['state_id'] ?>)" style="display: none;">
                                        <i class="fa fa-save"></i> Update State
                                    </button>

                                    <!-- Delete Button -->
                                    <a href="delete-state.php?id=<?= $state['state_id'] ?>" class="btn btn-danger btn-sm delete-btn" onclick="return confirmDelete('<?= htmlspecialchars($state['state_name']) ?>');">
                                        <i class="fa fa-trash"></i> Delete
                                    </a>

                                    <script>
                                        function confirmDelete(userName) {
                                            return confirm("Are you sure you want to delete this user : " + userName + "?");
                                        }
                                    </script>

                                    <!-- Cancel Button (Hidden Initially) -->
                                    <button class="btn btn-secondary btn-sm cancel-btn" onclick="cancelEdit(<?= $state['state_id'] ?>)" style="display: none;">
                                        <i class="fa fa-times"></i> Cancel
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>


                    <script>
                        function editState(stateId) {
                            let row = document.getElementById("row-" + stateId);
                            let nameCell = document.getElementById("state-name-" + stateId);
                            let editInput = nameCell.querySelector(".edit-mode");

                            // Store original value in case of cancel
                            editInput.setAttribute("data-original", editInput.value);

                            // Toggle visibility
                            nameCell.querySelector(".view-mode").style.display = "none";
                            editInput.style.display = "block";

                            row.querySelector(".edit-btn").style.display = "none";
                            row.querySelector(".update-btn").style.display = "inline-block";
                            row.querySelector(".delete-btn").style.display = "none";
                            row.querySelector(".cancel-btn").style.display = "inline-block";
                        }

                        function updateState(stateId) {
                            let nameCell = document.getElementById("state-name-" + stateId);
                            let editInput = nameCell.querySelector(".edit-mode");
                            let newStateName = editInput.value.trim();

                            if (newStateName === "") {
                                alert("State name cannot be empty!");
                                return;
                            }

                            // Send AJAX request to update-state.php
                            fetch("update-state.php", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/x-www-form-urlencoded"
                                    },
                                    body: `id=${stateId}&state_name=${encodeURIComponent(newStateName)}`
                                })
                                .then(response => response.text())
                                .then(data => {
                                    if (data === "success") {
                                        // Update UI
                                        nameCell.querySelector(".view-mode").textContent = newStateName;
                                        nameCell.querySelector(".view-mode").style.display = "block";
                                        editInput.style.display = "none";

                                        let row = document.getElementById("row-" + stateId);
                                        row.querySelector(".edit-btn").style.display = "inline-block";
                                        row.querySelector(".update-btn").style.display = "none";
                                        row.querySelector(".delete-btn").style.display = "inline-block";
                                        row.querySelector(".cancel-btn").style.display = "none";
                                    } else {
                                        alert("Error updating state!");
                                    }
                                });
                        }

                        function cancelEdit(stateId) {
                            let row = document.getElementById("row-" + stateId);
                            let nameCell = document.getElementById("state-name-" + stateId);
                            let editInput = nameCell.querySelector(".edit-mode");

                            // Restore original value
                            editInput.value = editInput.getAttribute("data-original");

                            // Toggle visibility back to view mode
                            nameCell.querySelector(".view-mode").style.display = "block";
                            editInput.style.display = "none";

                            row.querySelector(".edit-btn").style.display = "inline-block";
                            row.querySelector(".update-btn").style.display = "none";
                            row.querySelector(".delete-btn").style.display = "inline-block";
                            row.querySelector(".cancel-btn").style.display = "none";
                        }
                    </script>
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

        <!-- Right Side: Add New State -->
        <div class="col-md-4 mt-3 mt-md-0">
            <div class="card p-4">
                <h4 class="fw-bold text-center">Add New State</h4>
                <form action="state.php" method="POST">
                    <div class="mb-3">
                        <label for="state_name" class="form-label fw-bold">State Name</label>
                        <input type="text" class="form-control" name="state_name" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary px-4" name="add_state"><i class="fa fa-plus"></i> Add State</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>