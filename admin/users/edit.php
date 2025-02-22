<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../authentication/login.php");
    exit();
}

include_once __DIR__ . "/../includes/header.php";
include_once __DIR__ . "/../includes/sidebar.php";
include_once __DIR__ . "/../includes/db.php";

// Get user ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Invalid User ID!'); window.location.href='list.php';</script>";
    exit;
}

$user_id = $_GET['id'];

// Fetch user details
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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $about_me = $_POST['about_me'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $preferred_language = $_POST['preferred_language'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $pincode = $_POST['pincode'];

    $update_sql = "UPDATE users SET username=?, about_me=?, phone_number=?, email=?, preferred_language=?, city=?, state=?, pincode=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($stmt, "ssssssssi", $username, $about_me, $phone, $email, $preferred_language, $city, $state, $pincode, $user_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('User details updated successfully!'); window.location.href='user_detail.php?id=$user_id';</script>";
    } else {
        echo "<script>alert('Error updating user details!');</script>";
    }
}
?>

<div class="container main-container">
    <div class="p-4">
        <h3 class="fw-bold"><i class="fa fa-edit"></i> Edit User Details</h3>
        <hr>
        <form method="POST">
            <div class="row">
                <!-- Profile Image & User ID -->
                <div class="col-md-4 text-center">
                    <img src="../../assets/images/profile/no-profile.jpg"
                        alt="Profile Picture"
                        class="img-fluid rounded-circle border shadow-lg"
                        style="width: 150px; height: 150px; object-fit: cover;">
                    <p class="mt-3"><strong>User ID:</strong> #<?= htmlspecialchars($user['id']) ?></p>
                    <p class="text-muted">Joined on: <?= date("d M Y", strtotime($user['created_at'])) ?></p>
                </div>

                <!-- User Details -->
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa fa-user"></i> Username</label>
                            <input type="text" class="form-control" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa fa-envelope"></i> Email</label>
                            <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa fa-phone"></i> Phone</label>
                            <input type="text" class="form-control" name="phone" value="<?= htmlspecialchars($user['phone_number']) ?>" required>
                        </div>

                        <!-- Fetch languages from the database -->
                        <?php
                        $lang_query = "SELECT * FROM languages";
                        $lang_result = mysqli_query($conn, $lang_query);
                        ?>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fa fa-language"></i> Preferred Language</label>
                            <select class="form-control" name="preferred_language" required>
                                <?php while ($lang = mysqli_fetch_assoc($lang_result)) { ?>
                                    <option value="<?= htmlspecialchars($lang['language_name']) ?>"
                                        <?= ($user['preferred_language'] == $lang['language_name']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($lang['language_name']) ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php
                        // Fetch states from the 'location_state' table
                        $sql = "SELECT DISTINCT state_id, state_name FROM location_state";
                        $stateResult = $conn->query($sql);

                        // Fetch cities with their corresponding state_id
                        $sql = "SELECT city_id, city_name, state_id FROM location_city";
                        $cityResult = $conn->query($sql);
                        $cities = [];
                        while ($rowCity = $cityResult->fetch_assoc()) {
                            $cities[] = $rowCity;
                        }
                        ?>

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                // Parse JSON data from PHP
                                const cities = JSON.parse(document.getElementById("city-data").textContent);
                                const stateDropdown = document.getElementById("state");
                                const cityDropdown = document.getElementById("city");

                                function loadCities(stateId, selectedCityId = null) {
                                    // Reset city dropdown
                                    cityDropdown.innerHTML = '<option selected disabled>Select City</option>';

                                    // Filter cities based on selected state
                                    let filteredCities = cities.filter(city => city.state_id == stateId);
                                    filteredCities.forEach(city => {
                                        let option = document.createElement("option");
                                        option.value = city.city_id;
                                        option.textContent = city.city_name;

                                        // Auto-select user's city if it exists
                                        if (selectedCityId && city.city_id == selectedCityId) {
                                            option.selected = true;
                                        }

                                        cityDropdown.appendChild(option);
                                    });
                                }

                                // Load cities automatically if a state is selected (for edit mode)
                                let selectedState = "<?= htmlspecialchars($user['state']) ?>";
                                let selectedCity = "<?= htmlspecialchars($user['city']) ?>";

                                if (selectedState) {
                                    stateDropdown.value = selectedState;
                                    loadCities(selectedState, selectedCity);
                                }

                                // Load cities on state change
                                stateDropdown.addEventListener("change", function() {
                                    loadCities(this.value);
                                });
                            });
                        </script>

                        <!-- State Dropdown -->
                        <div class="col-12 col-sm-6 col-md-4">
                            <label class="form-label" for="state">State Name</label>
                            <select class="form-select" name="state" id="state">
                                <option selected disabled>Select State</option>
                                <?php while ($rowState = $stateResult->fetch_assoc()) { ?>
                                    <option value="<?= htmlspecialchars($rowState['state_id']) ?>"
                                        <?= ($user['state'] == $rowState['state_id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($rowState['state_name']) ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- City Dropdown -->
                        <div class="col-12 col-sm-6 col-md-4">
                            <label class="form-label" for="city">Select City</label>
                            <select class="form-select" name="city" id="city">
                                <option selected disabled>Select City</option>
                            </select>
                        </div>

                        <!-- Hidden JSON Data -->
                        <script type="application/json" id="city-data">
                            <?= json_encode($cities) ?>
                        </script>


                        <div class="col-md-4 mb-3">
                            <label class="form-label"><i class="fa fa-map-pin"></i> Pincode</label>
                            <input type="text" class="form-control" name="pincode" value="<?= htmlspecialchars($user['pincode']) ?>">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label"><i class="fa fa-user-edit"></i> About Me</label>
                            <textarea class="form-control" name="about_me" rows="3"><?= htmlspecialchars($user['about_me']) ?></textarea>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="user_detail.php?id=<?= $user['id'] ?>" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Cancel</a>
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save Changes</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include_once __DIR__ . "/../includes/footer.php"; ?>