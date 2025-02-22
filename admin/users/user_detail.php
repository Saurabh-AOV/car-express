<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../authentication/login.php");
    exit();
}

include_once __DIR__ . "/../includes/header.php";
include_once __DIR__ . "/../includes/sidebar.php";
include_once __DIR__ . "/../includes/db.php";

// Get user ID from URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Invalid User ID!'); window.location.href='list.php';</script>";
    exit;
}

$user_id = $_GET['id'];

// Fetch user data
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "<script>alert('User not found!'); window.location.href='list.php';</script>";
    exit;
}

// Fetch user's number of listings
$listing_sql = "SELECT COUNT(*) as total_listings FROM products WHERE user_id = ?";
$stmt2 = mysqli_prepare($conn, $listing_sql);
mysqli_stmt_bind_param($stmt2, "i", $user['phone_number']);
mysqli_stmt_execute($stmt2);
$result2 = mysqli_stmt_get_result($stmt2);
$listing_data = mysqli_fetch_assoc($result2);
$total_listings = $listing_data['total_listings'];

?>

<div class="container main-container">
    <div class="p-4">
        <div class="row">
            <!-- Profile Image & User Info -->
            <div class="col-md-4 text-center">
                <img src="../../assets/images/profile/no-profile.jpg"
                    alt="Profile Picture"
                    class="img-fluid rounded-circle border shadow-lg"
                    style="width: 150px; height: 150px; object-fit: cover;">
                <h4 class="mt-3"><?= htmlspecialchars($user['username']) ?></h4>
                <p class="text-muted">User ID: <strong>#<?= htmlspecialchars($user['id']) ?></strong></p>
                <p class="text-muted">Joined on: <?= date("d M Y", strtotime($user['created_at'])) ?></p>
            </div>


            <!-- User Details -->
            <div class="col-md-8">
                <h3 class="fw-bold"><i class="fa fa-user"></i> User Details</h3>
                <hr>
                <div class="row">
                    <div class="col-6">
                        <p><i class="fa fa-envelope"></i> <strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                        <p><i class="fa fa-phone"></i> <strong>Phone:</strong> <?= htmlspecialchars($user['phone_number']) ?></p>
                        <p><i class="fa fa-globe"></i> <strong>Preferred Language:</strong> <?= htmlspecialchars($user['preferred_language'] ?? 'N/A') ?></p>
                    </div>
                    <div class="col-6">
                        <?php
                        // Fetch State Name
                        $stateName = "N/A"; // Default value
                        if (!empty($user['state'])) {
                            $stateQuery = $conn->prepare("SELECT state_name FROM location_state WHERE state_id = ?");
                            $stateQuery->bind_param("i", $user['state']);
                            $stateQuery->execute();
                            $stateResult = $stateQuery->get_result();
                            if ($stateRow = $stateResult->fetch_assoc()) {
                                $stateName = $stateRow['state_name'];
                            }
                        }

                        // Fetch City Name
                        $cityName = "N/A"; // Default value
                        if (!empty($user['city'])) {
                            $cityQuery = $conn->prepare("SELECT city_name FROM location_city WHERE city_id = ?");
                            $cityQuery->bind_param("i", $user['city']);
                            $cityQuery->execute();
                            $cityResult = $cityQuery->get_result();
                            if ($cityRow = $cityResult->fetch_assoc()) {
                                $cityName = $cityRow['city_name'];
                            }
                        }
                        ?>

                        <!-- Display User Location -->
                        <p><i class="fa fa-city"></i> <strong>City:</strong> <?= htmlspecialchars($cityName) ?></p>
                        <p><i class="fa fa-map-marker-alt"></i> <strong>State:</strong> <?= htmlspecialchars($stateName) ?></p>

                        <p><i class="fa fa-map-pin"></i> <strong>Pincode:</strong> <?= htmlspecialchars($user['pincode'] ?? 'N/A') ?></p>
                    </div>
                </div>
                <hr>

                <!-- About Me -->
                <h5><i class="fa fa-user-edit"></i> About Me</h5>
                <p class="bg-light p-3 rounded"><?= !empty($user['about_me']) ? htmlspecialchars($user['about_me']) : 'No bio available.' ?></p>

                <hr>

                <!-- User Listings -->
                <div>
                    <h5><i class="fa fa-car"></i> User Listings</h5>
                    <div class="bg-warning p-3 rounded mb-3 d-flex justify-content-between align-items-center">
                        <p class="mb-0 text-dark ">
                            Total Listings: <strong><?= $total_listings ?></strong> </p>
                        <a href="../cars/list.php?user_id=<?= $user['phone_number'] ?>" class="btn btn-primary">
                            <i class="fa fa-eye"></i> View Listings
                        </a>

                    </div>
                </div>


                <!-- Action Buttons -->
                <div class="d-flex justify-content-between">
                    <a href="list.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back</a>
                    <div>
                        <a href="edit.php?id=<?= $user['id'] ?>" class="btn btn-warning"><i class="fa fa-edit"></i> Edit</a>
                        <a href="./delete.php?id=<?= $user['id'] ?>" class="btn btn-danger" onclick="return confirmDelete('<?= htmlspecialchars($user['username']) ?>');">
                            <i class="fa fa-trash"></i> Delete
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(userName) {
        return confirm("Are you sure you want to delete this user - " + userName + "?");
    }
</script>

<?php include_once __DIR__ . "/../includes/footer.php"; ?>