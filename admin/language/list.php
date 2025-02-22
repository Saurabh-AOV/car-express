<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../authentication/login.php");
    exit();
}

include '../includes/header.php';
include '../includes/sidebar.php';
include '../includes/db.php';

// Fetch search query
$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10; // Number of rows per page
$offset = ($page - 1) * $limit;

// Fetch total records
$totalQuery = "SELECT COUNT(*) as total FROM languages WHERE language_name LIKE ?";
$stmt = $conn->prepare($totalQuery);
$searchTerm = "%$search%";
$stmt->bind_param('s', $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
$totalRecords = $result->fetch_assoc()['total'];
$totalPages = ceil($totalRecords / $limit);

// Fetch languages with user count
$query = "SELECT l.language_id, l.language_code, l.language_name, 
                 (SELECT COUNT(*) FROM users WHERE FIND_IN_SET(l.language_name, users.preferred_language)) AS user_count
          FROM languages l 
          WHERE l.language_name LIKE ?
          LIMIT ? OFFSET ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('sii', $searchTerm, $limit, $offset);
$stmt->execute();
$languages = $stmt->get_result();
?>


<div class="container main-container">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3><i class="fa fa-language"></i> Languages</h3>
        <a href="add-language.php" class="btn btn-primary"><i class="fa fa-plus"></i> Add Language</a>
    </div>

    <!-- Search Form -->
    <form method="GET" class="mb-3" action="list.php">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search language..." value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="btn btn-secondary"><i class="fa fa-search"></i> Search</button>
        </div>
    </form>

    <?php if ($languages->num_rows > 0) { ?>
        <!-- Languages Table -->
        <div class="table-responsive" style="max-height: 358px; overflow-y: auto;">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Language Code</th>
                        <th>Language Name</th>
                        <th>Used by Users</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $languages->fetch_assoc()) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row['language_id'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($row['language_code'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($row['language_name'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($row['user_count'] ?? 'N/A') ?></td>

                            <td>
                                <a href="edit-language.php?id=<?php echo $row['language_id']; ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>

                                <a href="delete-language.php?id=<?php echo $row['language_id']; ?>" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete language ID : <?= $row['language_id'] ?>?')">
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
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="list.php?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>

    <?php } else { ?>
        <div class="alert alert-warning text-center mt-4">
            <i class="fa fa-exclamation-circle"></i> <strong>No Listings Available</strong>
        </div>
    <?php } ?>

</div>

<?php include '../includes/footer.php'; ?>