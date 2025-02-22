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

// Get city ID from URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "Invalid city ID!";
    header("Location: city.php");
    exit();
}

$city_id = intval($_GET['id']);

// Fetch city details
$cityQuery = "SELECT * FROM location_city WHERE city_id = ?";
$stmt = $conn->prepare($cityQuery);
$stmt->bind_param("i", $city_id);
$stmt->execute();
$cityResult = $stmt->get_result();
$cityData = $cityResult->fetch_assoc();

if (!$cityData) {
    $_SESSION['error'] = "City not found!";
    header("Location: city.php");
    exit();
}

// Fetch states
$stateQuery = "SELECT * FROM location_state";
$stateResult = $conn->query($stateQuery);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update'])) {
    $city_id = intval($_POST['city_id']);
    $state_name = trim($_POST['state_name']);
    $city_name = trim($_POST['city_name']);

    // Validate input
    if (empty($city_id) || empty($state_name) || empty($city_name)) {
        $_SESSION['error'] = "All fields are required!";
        header("Location: edit-city.php?id=" . $city_id);
        exit();
    }

    // Check if the state exists, if not, insert a new one
    $stateCheckQuery = "SELECT state_id FROM location_state WHERE state_name = ?";
    $stmt = $conn->prepare($stateCheckQuery);
    $stmt->bind_param("s", $state_name);
    $stmt->execute();
    $stateResult = $stmt->get_result();

    if ($stateResult->num_rows > 0) {
        $stateRow = $stateResult->fetch_assoc();
        $state_id = $stateRow['state_id'];
    } else {
        // Insert new state if it doesn't exist
        $insertStateQuery = "INSERT INTO location_state (state_name) VALUES (?)";
        $stmt = $conn->prepare($insertStateQuery);
        $stmt->bind_param("s", $state_name);
        if ($stmt->execute()) {
            $state_id = $stmt->insert_id; // Get new state ID
        } else {
            $_SESSION['error'] = "Failed to add new state!";
            header("Location: edit-city.php?id=" . $city_id);
            exit();
        }
    }

    // Check if the city name already exists in the selected state (to avoid duplicates)
    $checkQuery = "SELECT city_id FROM location_city WHERE city_name = ? AND state_id = ? AND city_id != ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("sii", $city_name, $state_id, $city_id);
    $stmt->execute();
    $checkResult = $stmt->get_result();

    if ($checkResult->num_rows > 0) {
        $_SESSION['error'] = "This city already exists in the selected state!";
        header("Location: edit-city.php?id=" . $city_id);
        exit();
    }

    // Update city
    $updateQuery = "UPDATE location_city SET city_name = ?, state_id = ? WHERE city_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("sii", $city_name, $state_id, $city_id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Location updated successfully!";
    } else {
        $_SESSION['error'] = "Failed to update location. Please try again.";
    }

    header("Location: city.php");
    exit();
}
?>

<div class="container main-container">
    <div class="card p-4">
        <h3 class="fw-bold mb-4 text-primary text-center">Edit Location</h3>

        <!-- Display success/error messages -->
        <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php } ?>

        <?php if (isset($_SESSION['success'])) { ?>
            <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php } ?>

        <form action="edit.php?id=<?= $city_id ?>" method="POST">
            <input type="hidden" name="city_id" value="<?= htmlspecialchars($city_id) ?>">

            <!-- State Selection -->
            <div class="mb-3">
                <label for="state_name" class="form-label fw-bold">State Name</label>
                <select class="form-control" name="state_name" required>
                    <?php while ($state = $stateResult->fetch_assoc()) { ?>
                        <option value="<?= htmlspecialchars($state['state_name']) ?>" <?= ($state['state_id'] == $cityData['state_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($state['state_name']) ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <!-- City Name -->
            <div class="mb-3">
                <label for="city_name" class="form-label fw-bold">City Name</label>
                <input type="text" class="form-control" name="city_name" value="<?= htmlspecialchars($cityData['city_name']) ?>" required>
            </div>

            <!-- Buttons -->
            <div class="text-center">
                <button type="submit" class="btn btn-primary px-4" name="update">Update City Name</button>
                <a href="city.php" class="btn btn-secondary px-4">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>