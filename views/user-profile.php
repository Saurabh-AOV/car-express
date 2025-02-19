<style>
    body {
        color: #797979;
        background: #f1f2f7;
        font-family: 'Open Sans', sans-serif;
        padding: 0px !important;
        margin: 0px !important;
        font-size: 13px;
        text-rendering: optimizeLegibility;
        -webkit-font-smoothing: antialiased;
        -moz-font-smoothing: antialiased;
    }

    .profile-nav,
    .profile-info {
        margin-top: 15px;
    }

    .profile-nav .user-heading {
        background: #ced4da;
        color: #495057;
        border-radius: 4px 4px 0 0;
        -webkit-border-radius: 4px 4px 0 0;
        padding: 30px;
        text-align: center;
    }

    .profile-nav .user-heading.round a {
        border-radius: 50%;
        -webkit-border-radius: 50%;
        border: 10px solid rgba(255, 255, 255, 0.3);
        display: inline-block;
    }

    .profile-nav .user-heading a img {
        width: 112px;
        height: 112px;
        border-radius: 50%;
        -webkit-border-radius: 50%;
    }

    .profile-nav .user-heading h1 {
        font-size: 22px;
        font-weight: 300;
        margin-bottom: 5px;
    }

    .profile-nav .user-heading p {
        font-size: 12px;
    }

    .profile-nav ul {
        margin-top: 1px;
    }

    .profile-nav ul>li {
        border-bottom: 1px solid #ebeae6;
        margin-top: 0;
        line-height: 30px;
    }

    .profile-nav ul>li:last-child {
        border-bottom: none;
    }

    .profile-nav ul>li>a {
        border-radius: 0;
        -webkit-border-radius: 0;
        color: #89817f;
        border-left: 5px solid #fff;
    }

    .profile-nav ul>li>a:hover,
    .profile-nav ul>li>a:focus,
    .profile-nav ul li.active a {
        background: #f8f7f5 !important;
        border-left: 5px solid #fbc02d;
        padding-left: 6px;
        color: #89817f !important;
    }

    .profile-nav ul>li:last-child>a:last-child {
        border-radius: 0 0 4px 4px;
        -webkit-border-radius: 0 0 4px 4px;
    }

    .profile-nav ul>li>a>i {
        font-size: 16px;
        padding-right: 10px;
        color: #bcb3aa;
    }

    .r-activity {
        margin: 6px 0 0;
        font-size: 12px;
    }


    .p-text-area,
    .p-text-area:focus {
        border: none;
        font-weight: 300;
        box-shadow: none;
        color: #c3c3c3;
        font-size: 16px;
    }

    .profile-info .panel-footer {
        background-color: #f8f7f5;
        border-top: 1px solid #e7ebee;
    }

    .profile-info .panel-footer ul li a {
        color: #7a7a7a;
    }

    .bio-graph-heading {
        background: #ced4da;
        color: #495057;
        text-align: center;
        font-style: italic;
        padding: 40px 110px;
        border-radius: 4px 4px 0 0;
        -webkit-border-radius: 4px 4px 0 0;
        font-size: 16px;
        font-weight: 300;
    }

    .bio-graph-info {
        color: #89817e;
    }

    .bio-graph-info h1 {
        font-size: 22px;
        font-weight: 300;
        margin: 0 0 20px;
    }

    .bio-row {
        width: 50%;
        float: left;
        margin-bottom: 10px;
        padding: 0 15px;
    }

    .bio-row p span {
        width: 100px;
        display: inline-block;
    }

    .bio-chart,
    .bio-desk {
        float: left;
    }

    .bio-chart {
        width: 40%;
    }

    .bio-desk {
        width: 60%;
    }

    .bio-desk h4 {
        font-size: 15px;
        font-weight: 400;
    }

    .bio-desk h4.terques {
        color: #4CC5CD;
    }

    .bio-desk h4.red {
        color: #e26b7f;
    }

    .bio-desk h4.green {
        color: #97be4b;
    }

    .bio-desk h4.purple {
        color: #caa3da;
    }

    .file-pos {
        margin: 6px 0 10px 0;
    }

    .profile-activity h5 {
        font-weight: 300;
        margin-top: 0;
        color: #c3c3c3;
    }

    .summary-head {
        background: #ee7272;
        color: #fff;
        text-align: center;
        border-bottom: 1px solid #ee7272;
    }

    .summary-head h4 {
        font-weight: 300;
        text-transform: uppercase;
        margin-bottom: 5px;
    }

    .summary-head p {
        color: rgba(255, 255, 255, 0.6);
    }

    ul.summary-list {
        display: inline-block;
        padding-left: 0;
        width: 100%;
        margin-bottom: 0;
    }

    ul.summary-list>li {
        display: inline-block;
        width: 19.5%;
        text-align: center;
    }

    ul.summary-list>li>a>i {
        display: block;
        font-size: 18px;
        padding-bottom: 5px;
    }

    ul.summary-list>li>a {
        padding: 10px 0;
        display: inline-block;
        color: #818181;
    }

    ul.summary-list>li {
        border-right: 1px solid #eaeaea;
    }

    ul.summary-list>li:last-child {
        border-right: none;
    }

    .activity {
        width: 100%;
        float: left;
        margin-bottom: 10px;
    }

    .activity.alt {
        width: 100%;
        float: right;
        margin-bottom: 10px;
    }

    .activity span {
        float: left;
    }

    .activity.alt span {
        float: right;
    }

    .activity span,
    .activity.alt span {
        width: 45px;
        height: 45px;
        line-height: 45px;
        border-radius: 50%;
        -webkit-border-radius: 50%;
        background: #eee;
        text-align: center;
        color: #fff;
        font-size: 16px;
    }

    .activity.terques span {
        background: #8dd7d6;
    }

    .activity.terques h4 {
        color: #8dd7d6;
    }

    .activity.purple span {
        background: #b984dc;
    }

    .activity.purple h4 {
        color: #b984dc;
    }

    .activity.blue span {
        background: #90b4e6;
    }

    .activity.blue h4 {
        color: #90b4e6;
    }

    .activity.green span {
        background: #aec785;
    }

    .activity.green h4 {
        color: #aec785;
    }

    .activity h4 {
        margin-top: 0;
        font-size: 16px;
    }

    .activity p {
        margin-bottom: 0;
        font-size: 13px;
    }

    .activity .activity-desk i,
    .activity.alt .activity-desk i {
        float: left;
        font-size: 18px;
        margin-right: 10px;
        color: #bebebe;
    }

    .activity .activity-desk {
        margin-left: 70px;
        position: relative;
    }

    .activity.alt .activity-desk {
        margin-right: 70px;
        position: relative;
    }

    .activity.alt .activity-desk .panel {
        float: right;
        position: relative;
    }

    .activity-desk .panel {
        background: #F4F4F4;
        display: inline-block;
    }


    .activity .activity-desk .arrow {
        border-right: 8px solid #F4F4F4 !important;
    }

    .activity .activity-desk .arrow {
        border-bottom: 8px solid transparent;
        border-top: 8px solid transparent;
        display: block;
        height: 0;
        left: -7px;
        position: absolute;
        top: 13px;
        width: 0;
    }

    .activity-desk .arrow-alt {
        border-left: 8px solid #F4F4F4 !important;
    }

    .activity-desk .arrow-alt {
        border-bottom: 8px solid transparent;
        border-top: 8px solid transparent;
        display: block;
        height: 0;
        right: -7px;
        position: absolute;
        top: 13px;
        width: 0;
    }

    .activity-desk .album {
        display: inline-block;
        margin-top: 10px;
    }

    .activity-desk .album a {
        margin-right: 10px;
    }

    .activity-desk .album a:last-child {
        margin-right: 0px;
    }
</style>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

<?php
// Get user_id from request
$userId = isset($_GET['user_id']) ? intval($_GET['user_id']) : 9876543210;

$sql = "SELECT username, email, phone_number, created_at, city, state,about_me, pincode, preferred_language FROM users WHERE phone_number = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$userDetailResult = $stmt->get_result();

// Fetch data
if ($userDetailResult->num_rows > 0) {
    $userData = $userDetailResult->fetch_assoc();

    // Split the name into first and last
    $nameParts = explode(' ', $userData['username'], 2);
    $firstName = $nameParts[0]; // First name is always available
    $lastName = isset($nameParts[1]) ? $nameParts[1] : ""; // Only set if there's a second part

} else {
    echo json_encode(["error" => "User not found"]);
}

// Assuming $conn is your database connection
$cityId = $userData['city'];
$stateId = $userData['state'];

// Prepare and execute the statement
// 1️⃣ **Fetch City Name**
$cityQuery = "SELECT city_name FROM location_city WHERE city_id = ?";
$stmt = $conn->prepare($cityQuery);
$stmt->bind_param("i", $cityId);
$stmt->execute();
$cityResult = $stmt->get_result();
$cityRow = $cityResult->fetch_assoc();
$cityName = $cityRow ? ucwords(htmlspecialchars($cityRow['city_name'])) : "Unknown City";
$stmt->close();

// 2️⃣ **Fetch State Name**
$stateQuery = "SELECT state_name FROM location_state WHERE state_id = ?";
$stmt = $conn->prepare($stateQuery);
$stmt->bind_param("i", $stateId);
$stmt->execute();
$stateResult = $stmt->get_result();
$stateRow = $stateResult->fetch_assoc();
$stateName = $stateRow ? ucwords(htmlspecialchars($stateRow['state_name'])) : "Unknown State";

?>

<div class="container-fluid bootstrap snippets bootdey">
    <div class="row">

        <!-- Side bar -->
        <div class="profile-nav col-md-3">
            <div class="panel">
                <div class="user-heading round">
                    <a href="#">
                        <img src="<?php echo !empty($userData['profile_image']) ? htmlspecialchars($userData['profile_image']) : '../assets/images/profile/no-profile.jpg'; ?>"
                            alt="Profile Image"
                            draggable="false">

                    </a>
                    <h1><?php echo $userData['username'] ?></h1>
                    <p><?php echo $userData['email'] ?></p>
                </div>

                <ul class="nav nav-pills nav-stacked bg-light">
                    <li style="cursor: pointer;" class="w-100 px-2 py-2"><a class="nav-link" data-target="profileSection"> <i class="fa fa-user"></i> Profile</a></li>
                    <li style="cursor: pointer;" class="w-100 px-2 py-2"><a class="nav-link" data-target="editSection"> <i class="fa fa-edit"></i> Edit profile</a></li>
                    <li style="cursor: pointer;" class="w-100 px-2 py-2"><a class="nav-link" data-target="dashboardSection"> <i class="fa fa-cogs"></i> Dashboard</a></li>
                    <li style="cursor: pointer;" class="w-100 px-2 py-2"><a class="nav-link" data-target="wishlistSection"> <i class="fa fa-gift"></i> Wishlist</a></li>
                    <li style="cursor: pointer;" class="w-100 px-2 py-2"><a class="nav-link" data-target="sellSection"> <i class="fa fa-th-list"></i> Sell</a></li>

                </ul>
            </div>
        </div>

        <!-- Large area -->
        <div class="profile-info col-md-9">

            <!-- Profile -->
            <div id="profileSection" class="panel section">
                <div class="bio-graph-heading">
                    <?php echo !empty($userData['about_me']) ? htmlspecialchars($userData['about_me']) : "Aliquam ac magna metus. Nam sed arcu non tellus fringilla fringilla ut vel ipsum. Aliquam ac magna metus."; ?>

                </div>
                <div class="panel-body bio-graph-info mt-3">
                    <h1>Your details</h1>
                    <div class="row">
                        <div class="bio-row">
                            <p><span>First Name </span>: <?php echo htmlspecialchars($firstName); ?></p>
                        </div>

                        <?php if (!empty($lastName)) : ?>
                            <div class="bio-row">
                                <p><span>Last Name </span>: <?php echo htmlspecialchars($lastName); ?></p>
                            </div>
                        <?php endif; ?>
                        <div class="bio-row">
                            <p><span>Email </span>: <?php echo $userData['email'] ?></p>
                        </div>
                        <div class="bio-row">
                            <p><span>Mobile </span>: <?php echo $userData['phone_number'] ?></p>
                        </div>
                        <div class="bio-row">
                            <p><span>Language </span>: <?php echo $userData['preferred_language'] ?></p>
                        </div>
                        <div class="bio-row">
                            <p><span>Join Date </span>: <?php echo htmlspecialchars($formattedDate = date("d M, Y", strtotime($userData['created_at']))) ?></p>
                        </div>
                        <div class="bio-row">
                            <p><span>Address</span>: <?php echo $cityName . ', ' . $stateName . ', India' ?></p>
                        </div>
                        <div class="bio-row">
                            <p><span>Pincode</span>: <?php echo !empty($userData['pincode']) ? htmlspecialchars($userData['pincode']) : "Not available"; ?></p>
                        </div>


                    </div>
                </div>
            </div>

            <!-- Edit profile -->
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
                $userName = $_POST['username'];
                $aboutMe = $_POST['about_me'];
                $email = $_POST['email'];
                $city = $_POST['city'];
                $state = $_POST['state'];
                $preferredLanguage = $_POST['preferred_language'];
                $pincode = $_POST['pincode'];

                // Check if user ID exists
                if (!isset($userData['phone_number'])) {
                    die("User ID is missing.");
                }

                // Update query
                $updateQuery = "UPDATE users SET username = ?, about_me = ?, email = ?, city = ?, state = ?, preferred_language = ?, pincode = ? WHERE phone_number = ?";
                $stmt = $conn->prepare($updateQuery);

                if ($stmt) {
                    $stmt->bind_param("sssssssi", $userName, $aboutMe, $email, $city, $state, $preferredLanguage, $pincode, $userData['phone_number']);
                    if ($stmt->execute()) {
                        $stmt->close();
                        unset($userName, $aboutMe, $email, $city, $state, $preferredLanguage, $pincode);
                        // Redirect to the same page to prevent form resubmission
                        header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
                        exit();
                    } else {
                        echo "Error updating profile: " . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    echo "SQL Error: " . $conn->error;
                }
            }
            ?>
            <div id="editSection" class="panel section d-none">
                <form method="POST" action="">
                    <div class="bio-graph-heading">
                        <textarea name="about_me"><?php echo !empty($userData['about_me']) ? htmlspecialchars($userData['about_me']) : "Aliquam ac magna metus. Nam sed arcu non tellus fringilla fringilla ut vel ipsum. Aliquam ac magna metus."; ?></textarea>
                    </div>
                    <div class="panel-body bio-graph-info mt-3">
                        <h1>Edit Profile</h1>
                        <div class="row">
                            <div class="bio-row">
                                <p><span>Name </span>: <input class="form-control" type="text" name="username" value="<?php echo htmlspecialchars($userData['username']); ?>"></p>
                            </div>
                            <div class="bio-row">
                                <p><span>Email </span>: <input class="form-control" type="email" name="email" value="<?php echo htmlspecialchars($userData['email']); ?>"></p>
                            </div>


                            <?php
                            // Fetch states from the 'location_state' table
                            $sql = "SELECT DISTINCT state_id, state_name FROM location_state";
                            $stateResult = $conn->query($sql);

                            // Fetch cities with their corresponding state_id
                            $sql = "SELECT city_id, city_name, state_id FROM location_city";
                            $cityResult = $conn->query($sql);
                            $cities = [];
                            while ($row = $cityResult->fetch_assoc()) {
                                $cities[] = $row;
                            }
                            ?>

                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    // Parse JSON data from PHP
                                    const cities = JSON.parse(document.getElementById("city-data").textContent);

                                    document.getElementById("state").addEventListener("change", function() {
                                        let stateId = this.value;
                                        let cityDropdown = document.getElementById("city");

                                        // Reset city dropdown
                                        cityDropdown.innerHTML = '<option selected disabled>Select City</option>';

                                        // Filter cities based on selected state
                                        let filteredCities = cities.filter(city => city.state_id == stateId);
                                        filteredCities.forEach(city => {
                                            let option = document.createElement("option");
                                            option.value = city.city_id;
                                            option.textContent = city.city_name;
                                            cityDropdown.appendChild(option);
                                        });
                                    });
                                });
                            </script>

                            <div class="bio-row">
                                <p><span>State </span>: <select class="form-select" name="state" id="state">
                                        <option selected disabled>Select State</option>
                                        <?php
                                        while ($row = $stateResult->fetch_assoc()) {
                                            echo "<option value='" . htmlspecialchars($row['state_id']) . "'>" . htmlspecialchars($row['state_name']) . "</option>";
                                        }
                                        ?>
                                    </select></p>
                            </div>

                            <div class="bio-row">
                                <p><span>City </span>: <select class="form-select" name="city" id="city">
                                        <option selected disabled>Select City</option>
                                    </select></p>
                            </div>
                            <script type="application/json" id="city-data">
                                <?= json_encode($cities) ?>
                            </script>

                            <div class="bio-row">
                                <p><span>Language </span>:
                                    <select class="form-select bg-transparent" id="languageSelect" name="preferred_language" style="outline:0; border:0;">
                                        <?php
                                        // Fetch language data
                                        $languageQuery = "SELECT language_id, language_name FROM languages";
                                        $languageResult = $conn->query($languageQuery);

                                        $selectedLanguage = $userData['preferred_language'];
                                        if ($languageResult->num_rows > 0) {
                                            while ($row = $languageResult->fetch_assoc()) {
                                                $selected = ($row['language_name'] === $selectedLanguage) ? "selected" : "";
                                                echo "<option value='" . htmlspecialchars($row['language_name']) . "' $selected>" . htmlspecialchars($row['language_name']) . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </p>
                            </div>

                            <div class="bio-row">
                                <p><span>Pincode</span>: <input type="tel" id="pincode" name="pincode" class="form-control" pattern="\d{6}" maxlength="6" value="<?php echo htmlspecialchars($userData['pincode']); ?>"></p>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" name="update_profile">Update Profile</button>
                    </div>
                </form>
            </div>

            <!-- Dashboard -->
            <div id="dashboardSection" class="container-fluid d-none section">
                <div class="row gap-md-0 gap-sm-0 gap-2">
                    <!-- Total Users Card -->
                    <div class="col-md-4 col-sm-6 col-12 col-sm-6 col-12">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h5 class="card-title">Wishlist</h5>
                                <p class="card-text fs-4"><?php
                                                            // Fetch wishlist count for the user
                                                            $sql = "SELECT COUNT(*) AS wishlist_count FROM wishlist WHERE user_id = $userId";
                                                            $result = $conn->query($sql);

                                                            if ($result->num_rows > 0) {
                                                                $row = $result->fetch_assoc();
                                                                $wishlistCount = $row['wishlist_count'];
                                                            } else {
                                                                $wishlistCount = 0;
                                                            }

                                                            // Print the count
                                                            echo $wishlistCount;
                                                            ?></p> <!-- Dynamically fetched total users -->
                                <a data-target="wishlistSection" class="nav-link btn py-2 bg-light text-dark">View wishlist</a>
                            </div>
                        </div>
                    </div>

                    <!-- Total Universities Card -->
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5 class="card-title">Your listing</h5>
                                <p class="card-text fs-4"><?php

                                                            // Fetch wishlist count for the user
                                                            $sql = "SELECT COUNT(*) AS listing_count FROM products WHERE user_id = $userId";
                                                            $result = $conn->query($sql);

                                                            if ($result->num_rows > 0) {
                                                                $row = $result->fetch_assoc();
                                                                $listingCount = $row['listing_count'];
                                                            } else {
                                                                $listingCount = 0;
                                                            }

                                                            // Print the count
                                                            echo $listingCount;
                                                            ?></p> <!-- Dynamically fetched total universities -->
                                <a data-target="sellSection" class="nav-link btn py-2 bg-light text-dark">View Listing</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Wishlist listing -->
            <div id="wishlistSection" class="container-fluid section d-none">
                <div class="row g-4">
                    <?php



                    // Fetch product IDs from the wishlist
                    $sql = "SELECT product_id FROM wishlist WHERE user_id = $userId";
                    $result = $conn->query($sql);

                    $productIds = [];

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $productIds[] = $row['product_id'];
                        }
                    } else {
                        echo "<div class='col-12 text-center'><h4 class='text-danger'>No Wishlist Items Found</h4></div>";
                    }


                    // Check if there are product IDs
                    if (!empty($productIds)) {
                        // Convert array to a comma-separated string for SQL IN clause
                        $productIdsString = implode(',', array_map('intval', $productIds));

                        $query = "SELECT product_id, product_image, price, created_at, product_name AS title, 
                         location_city AS address, year_of_registration, mileage
                  FROM products 
                  WHERE product_id IN ($productIdsString) 
                  ORDER BY created_at DESC";

                        $resultProductCard = $conn->query($query);

                        if (!$resultProductCard) {
                            die("<div class='col-12 text-center'><h4 class='text-danger'>SQL Error: " . $conn->error . "</h4></div>");
                        }

                        if ($resultProductCard->num_rows > 0) {
                            while ($row = $resultProductCard->fetch_assoc()) {
                                // Calculate time ago
                                $createdAt = new DateTime($row['created_at']);
                                $now = new DateTime();
                                $diffInSeconds = $now->getTimestamp() - $createdAt->getTimestamp();

                                if ($diffInSeconds < 0) {
                                    $timeAgo = "Just now";
                                } elseif ($diffInSeconds < 60) {
                                    $timeAgo = "$diffInSeconds second" . ($diffInSeconds > 1 ? 's' : '') . " ago";
                                } elseif ($diffInSeconds < 3600) {
                                    $minutes = floor($diffInSeconds / 60);
                                    $timeAgo = "$minutes minute" . ($minutes > 1 ? 's' : '') . " ago";
                                } elseif ($diffInSeconds < 86400) {
                                    $hours = floor($diffInSeconds / 3600);
                                    $timeAgo = "$hours hour" . ($hours > 1 ? 's' : '') . " ago";
                                } elseif ($diffInSeconds < 2592000) {
                                    $days = floor($diffInSeconds / 86400);
                                    $timeAgo = "$days day" . ($days > 1 ? 's' : '') . " ago";
                                } elseif ($diffInSeconds < 31536000) {
                                    $months = floor($diffInSeconds / 2592000);
                                    $timeAgo = "$months month" . ($months > 1 ? 's' : '') . " ago";
                                } else {
                                    $years = floor($diffInSeconds / 31536000);
                                    $timeAgo = "$years year" . ($years > 1 ? 's' : '') . " ago";
                                }

                                // City name lookup
                                $city_id = (int) $row['address'];
                                $city_name = isset($cityNames[$city_id]) ? $cityNames[$city_id] : "Unknown City";
                    ?>

                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <a href="/car-express/public/product-detail?listing=<?php echo $row['product_id']; ?>" class="text-dark" style="text-decoration:none;">
                                        <div class="card shadow-sm p-1">
                                            <!-- Favorite Icon -->
                                            <div class="favorite">
                                                <i class="bi bi-heart-fill text-success" style="cursor: pointer;"></i> <!-- Filled heart if in wishlist -->
                                            </div>

                                            <!-- Product Image -->
                                            <div class="d-sm-block d-md-none p-0" style="height: 10rem;">
                                                <img src="../image.jpg" class="card-img-top w-100" alt="Product Image" style="object-fit: cover; height: 100%; width: 100%;">
                                            </div>

                                            <div class="d-none d-md-block">
                                                <img src="../image.jpg" class="card-img-top" alt="Product Image">
                                            </div>

                                            <div class="card-body">
                                                <!-- Price -->
                                                <p class="price">₹<?php echo number_format($row['price']); ?></p>

                                                <!-- Title with Ellipsis -->
                                                <h6 class="card-title text-truncate" title="<?php echo htmlspecialchars($row['title']); ?>" style="max-width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                    <?php echo htmlspecialchars($row['title']); ?>
                                                </h6>

                                                <!-- Year & KM -->
                                                <p class="text-muted" style="margin-bottom:2px;">
                                                    <?php echo isset($row['year_of_registration']) ? "• " . $row['year_of_registration'] : "";  ?>
                                                    <?php echo isset($row['mileage']) ? "• " . number_format($row['mileage']) . " Mileage" : "" ?>
                                                </p>

                                                <div class="d-flex justify-content-between">
                                                    <!-- City name -->
                                                    <p class="text-muted small mb-0"><?php echo $city_name; ?></p>
                                                    <!-- Listing Date -->
                                                    <p class="listed mb-0"><?php echo $timeAgo; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                    <?php
                            }
                        } else {
                            echo '<div class="col-12 text-center"><h4 class="text-muted">No products found</h4></div>';
                        }
                    }
                    ?>
                </div>

            </div>

            <!-- Your listing -->
            <div id="sellSection" class="container-fluid section d-none">
                <div class="row g-4">
                    <?php
                    $querySell = "SELECT product_id, product_image, price, created_at, product_name AS title, 
                         location_city AS address, year_of_registration, mileage
                  FROM products 
                  WHERE user_id = $userId 
                  ORDER BY created_at DESC";


                    $resultSellProduct = $conn->query($querySell);

                    if (!$resultSellProduct) {
                        die("<div class='col-12 text-center'><h4 class='text-danger'>SQL Error: " . $conn->error . "</h4></div>");
                    }

                    if ($resultSellProduct->num_rows > 0) {
                        while ($row = $resultSellProduct->fetch_assoc()) {
                            // Calculate time ago
                            $createdAt = new DateTime($row['created_at']);
                            $now = new DateTime();
                            $diffInSeconds = $now->getTimestamp() - $createdAt->getTimestamp();

                            if ($diffInSeconds < 0) {
                                $timeAgo = "Just now";
                            } elseif ($diffInSeconds < 60) {
                                $timeAgo = "$diffInSeconds second" . ($diffInSeconds > 1 ? 's' : '') . " ago";
                            } elseif ($diffInSeconds < 3600) {
                                $minutes = floor($diffInSeconds / 60);
                                $timeAgo = "$minutes minute" . ($minutes > 1 ? 's' : '') . " ago";
                            } elseif ($diffInSeconds < 86400) {
                                $hours = floor($diffInSeconds / 3600);
                                $timeAgo = "$hours hour" . ($hours > 1 ? 's' : '') . " ago";
                            } elseif ($diffInSeconds < 2592000) {
                                $days = floor($diffInSeconds / 86400);
                                $timeAgo = "$days day" . ($days > 1 ? 's' : '') . " ago";
                            } elseif ($diffInSeconds < 31536000) {
                                $months = floor($diffInSeconds / 2592000);
                                $timeAgo = "$months month" . ($months > 1 ? 's' : '') . " ago";
                            } else {
                                $years = floor($diffInSeconds / 31536000);
                                $timeAgo = "$years year" . ($years > 1 ? 's' : '') . " ago";
                            }

                            // City name lookup
                            $city_id = (int) $row['address'];
                            $city_name = isset($cityNames[$city_id]) ? $cityNames[$city_id] : "Unknown City";
                    ?>

                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <a href="/car-express/public/product-detail?listing=<?php echo $row['product_id']; ?>" class="text-dark" style="text-decoration:none;">
                                    <div class="card shadow-sm p-1">

                                        <!-- Product Image -->
                                        <div class="d-sm-block d-md-none p-0" style="height: 10rem;">
                                            <img src="../image.jpg" class="card-img-top w-100" alt="Product Image" style="object-fit: cover; height: 100%; width: 100%;">
                                        </div>

                                        <div class="d-none d-md-block">
                                            <img src="../image.jpg" class="card-img-top" alt="Product Image">
                                        </div>

                                        <div class="card-body">
                                            <!-- Price -->
                                            <p class="price">₹<?php echo number_format($row['price']); ?></p>

                                            <!-- Title with Ellipsis -->
                                            <h6 class="card-title text-truncate" title="<?php echo htmlspecialchars($row['title']); ?>" style="max-width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                <?php echo htmlspecialchars($row['title']); ?>
                                            </h6>

                                            <!-- Year & KM -->
                                            <p class="text-muted" style="margin-bottom:2px;">
                                                <?php echo isset($row['year_of_registration']) ? "• " . $row['year_of_registration'] : "";  ?>
                                                <?php echo isset($row['mileage']) ? "• " . number_format($row['mileage']) . " Mileage" : "" ?>
                                            </p>

                                            <div class="d-flex justify-content-between">
                                                <!-- City name -->
                                                <p class="text-muted small mb-0"><?php echo $city_name; ?></p>
                                                <!-- Listing Date -->
                                                <p class="listed mb-0"><?php echo $timeAgo; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                    <?php
                        }
                    } else {
                        echo '<div class="col-12 text-center"><h4 class="text-muted">No products found</h4></div>';
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let navLinks = document.querySelectorAll(".nav-link");

        navLinks.forEach(function(link) {
            link.addEventListener("click", function(e) {
                e.preventDefault();
                let targetSection = this.getAttribute("data-target");

                document.querySelectorAll(".section").forEach(function(section) {
                    section.classList.add("d-none");
                });

                document.getElementById(targetSection).classList.remove("d-none");
            });
        });
    });
</script>