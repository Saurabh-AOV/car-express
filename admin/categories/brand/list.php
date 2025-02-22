<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../../authentication/login.php");
    exit();
}

include '../../includes/header.php';
include '../../includes/sidebar.php';
include '../../includes/db.php';

// Search functionality
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Pagination settings
$limit = 10; // Number of records per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Fetch brands with search & pagination
$brandQuery = "SELECT * FROM car_brands WHERE brand_name LIKE ? ORDER BY id DESC LIMIT ?, ?";
$stmt = $conn->prepare($brandQuery);
$searchParam = "%$search%";
$stmt->bind_param("sii", $searchParam, $offset, $limit);
$stmt->execute();
$brandResult = $stmt->get_result();

// Get total records for pagination
$totalQuery = "SELECT COUNT(*) AS total FROM car_brands WHERE brand_name LIKE ?";
$stmt = $conn->prepare($totalQuery);
$stmt->bind_param("s", $searchParam);
$stmt->execute();
$totalResult = $stmt->get_result();
$totalRow = $totalResult->fetch_assoc();
$totalRecords = $totalRow['total'];
$totalPages = ceil($totalRecords / $limit);
?>

<style>
    .main-container {
        margin-left: 200px;
        margin-top: 80px;
        height: calc(100vh - 100px);
        overflow-y: auto;
    }

    @media (max-width: 770px) {
        .main-container {
            margin-left: 0;
        }
    }
</style>

<div class="container main-container">
    <div class="row">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="fw-bold">Brand List</h3>
            </div>

            <!-- Success & Error Messages -->
            <?php if (isset($_SESSION['success'])) { ?>
                <div class="alert alert-success"><?= $_SESSION['success'];
                                                    unset($_SESSION['success']); ?></div>
            <?php } ?>
            <?php if (isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger"><?= $_SESSION['error'];
                                                unset($_SESSION['error']); ?></div>
            <?php } ?>

            <!-- Search Bar -->
            <form method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search by brand name..." value="<?= htmlspecialchars($search) ?>">
                    <button type="submit" class="btn btn-secondary">Search</button>
                </div>
            </form>



            <!-- Brand Table -->
            <div class="table-responsive" style="overflow-y: auto; height: 50vh">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Brand Name</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $brandResult->fetch_assoc()) { ?>
                            <tr id="row-<?= $row['id'] ?>">
                                <td><?= $row['id'] ?></td>
                                <td id="brand-name-<?= $row['id'] ?>">
                                    <?= htmlspecialchars($row['brand_name']) ?>
                                </td>
                                <td><?= $row['created_at'] ?></td>
                                <td id="actions-<?= $row['id'] ?>">
                                    <a href="javascript:void(0);" class="btn btn-warning btn-sm" onclick="editBrand(<?= $row['id'] ?>, '<?= htmlspecialchars($row['brand_name']) ?>')">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <a href="delete-brand.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirmDelete('<?= htmlspecialchars($row['brand_name']) ?>');">
                                        <i class="fa fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <script>
                    function editBrand(id, brandName) {
                        // Replace brand name with input field
                        document.getElementById(`brand-name-${id}`).innerHTML = `<input type="text" class="form-control" id="brand-input-${id}" value="${brandName}">`;

                        // Replace actions with Update & Cancel buttons
                        document.getElementById(`actions-${id}`).innerHTML = `
        <a href="javascript:void(0);" class="btn btn-success btn-sm" onclick="updateBrand(${id})">
            <i class="fa fa-save"></i> Update
        </a>
        <a href="javascript:void(0);" class="btn btn-secondary btn-sm" onclick="cancelEdit(${id}, '${brandName}')">
            <i class="fa fa-times"></i> Cancel
        </a>
    `;
                    }

                    function cancelEdit(id, originalName) {
                        // Restore original brand name
                        document.getElementById(`brand-name-${id}`).innerHTML = originalName;

                        // Restore original actions
                        document.getElementById(`actions-${id}`).innerHTML = `
        <a href="javascript:void(0);" class="btn btn-warning btn-sm" onclick="editBrand(${id}, '${originalName}')">
            <i class="fa fa-edit"></i> Edit
        </a>
        <a href="delete-brand.php?id=${id}" class="btn btn-danger btn-sm" onclick="return confirmDelete('${originalName}');">
            <i class="fa fa-trash"></i> Delete
        </a>
    `;
                    }

                    function updateBrand(id) {
                        let inputField = document.getElementById(`brand-input-${id}`);
                        if (!inputField) {
                            alert("Error: Input field not found!");
                            return;
                        }

                        let newName = inputField.value.trim();
                        if (newName === '') {
                            alert("Brand name cannot be empty!");
                            return;
                        }

                        // Prepare the data for sending via AJAX
                        let formData = new FormData();
                        formData.append("id", id);
                        formData.append("brand_name", newName);

                        // Send AJAX request to update brand in the database
                        let xhr = new XMLHttpRequest();
                        xhr.open("POST", "update-brand.php", true);

                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === 4) {
                                if (xhr.status === 200) {
                                    try {
                                        let response = JSON.parse(xhr.responseText);

                                        if (response.success) {
                                            // Update the UI with the new brand name
                                            document.getElementById(`brand-name-${id}`).innerHTML = newName;

                                            // Restore original actions
                                            document.getElementById(`actions-${id}`).innerHTML = `
                            <a href="javascript:void(0);" class="btn btn-warning btn-sm" onclick="editBrand(${id}, '${newName}')">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <a href="delete-brand.php?id=${id}" class="btn btn-danger btn-sm" onclick="return confirmDelete('${newName}');">
                                <i class="fa fa-trash"></i> Delete
                            </a>
                        `;
                                        } else {
                                            alert("Failed to update brand: " + response.message);
                                        }
                                    } catch (e) {
                                        alert("Error processing response: " + e.message);
                                        console.error("Response Error:", xhr.responseText);
                                    }
                                } else {
                                    alert("Request failed. Status: " + xhr.status);
                                    console.error("AJAX Error:", xhr.responseText);
                                }
                            }
                        };

                        xhr.send(formData);
                    }


                    function confirmDelete(value) {
                        return confirm("Are you sure you want to delete this user : " + value + "?");
                    }
                </script>
            </div>

            <nav>
            <ul class="pagination">
                <?php if ($page > 1) { ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= ($page - 1) ?>">Previous</a>
                    </li>
                <?php } ?>

                <?php
                if ($totalPages <= 5) {
                    // Show all pages if total pages are 5 or less
                    for ($i = 1; $i <= $totalPages; $i++) {
                        echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '">
                        <a class="page-link" href="?page=' . $i . '">' . $i . '</a>
                      </li>';
                    }
                } else {
                    // Show first 2 pages
                    for ($i = 1; $i <= 2; $i++) {
                        echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '">
                        <a class="page-link" href="?page=' . $i . '">' . $i . '</a>
                      </li>';
                    }

                    // Add ellipsis if needed
                    if ($page > 4) {
                        echo '<li class="page-item disabled"><a class="page-link">...</a></li>';
                    }

                    // Show last 2 pages
                    for ($i = max(3, $totalPages - 1); $i <= $totalPages; $i++) {
                        echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '">
                        <a class="page-link" href="?page=' . $i . '">' . $i . '</a>
                      </li>';
                    }
                }
                ?>

                <?php if ($page < $totalPages) { ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= ($page + 1) ?>">Next</a>
                    </li>
                <?php } ?>
            </ul>
        </nav>

        </div>

       


        <!-- Right Side: Add New Brand -->
        <div class="col-md-4">
            <div class="card shadow-lg p-4">
                <h4 class="fw-bold text-primary text-center">Add New Brand</h4>
                <form action="add-brand.php" method="POST">
                    <div class="mb-3">
                        <label for="brand_name" class="form-label fw-bold">Brand Name</label>
                        <input type="text" class="form-control" name="brand_name" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary px-4" name="add_brand">Add Brand</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>