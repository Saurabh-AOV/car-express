<?php

session_start();

// Fomating text
require_once __DIR__ . "/../app/helpers/FormatingTextHelper.php";

// Fetch UserId
// $userId = 9876543210;

// Location
$cityQuery = "
    SELECT c.city_id, c.city_name, s.state_name 
    FROM location_city c
    JOIN location_state s ON c.state_id = s.state_id
    ORDER BY s.state_name, c.city_name";  // Sort by state and then city
$citiesResult = $conn->query($cityQuery);

$states = [];
while ($row = $citiesResult->fetch_assoc()) {
    $stateName = htmlspecialchars($row['state_name']);
    $cityName = htmlspecialchars($row['city_name']);
    $states[$stateName][] = $cityName;
}

// If user present
$preferredLanguage = "English"; // Default language

if (isset($userId)) {
    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT preferred_language FROM users WHERE phone_number = ?");
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch language preference
    if ($result && $result->num_rows > 0) {
        $languageRow = $result->fetch_assoc();
        $preferredLanguage = $languageRow["preferred_language"];
    }
}

// Output the preferred language
echo htmlspecialchars($preferredLanguage);

// Replace with your Fast2SMS API key
$api_key = "2lEn0Mrzdw35NIsJWaB4ZLjfRC6Fg8ueGTYb79VhKmHqSxo1OD6IwyLCeP3i02tqbfU85OBQlSWaFjHT";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['send_otp'])) {
        $phone = $_POST['phone'];
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;


        $_SESSION['phone'] = $phone;

        $api_url = "https://www.fast2sms.com/dev/bulkV2?authorization=$api_key&route=otp&variables_values=$otp&flash=0&numbers=$phone";

        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_exec($ch);
        curl_close($ch);

        echo json_encode(["status" => "error", "message" => "OTP sent verified"]);
        // $response = curl_exec($ch);

        // if (curl_errno($ch)) {
        //     $error_msg = curl_error($ch);
        //     echo "cURL Error: $error_msg";
        //     curl_close($ch);
        //     exit;
        // }

        // $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // curl_close($ch);

        // if ($http_status === 200) {
        //     echo "OTP sent successfully.";
        //     $testingOTP = $_SESSION['otp'];
        //     echo "<script>console.log($testingOTP)</script>";
        // } else {
        //     echo "Failed to send OTP.";
        // }
        // exit;
    }

    if (isset($_POST['verify_otp'])) {
        $entered_otp = $_POST['otp'];
        if (isset($_SESSION['otp']) && $_SESSION['otp'] == $entered_otp) {
            echo "<script>console.log($testingOTP)</script>";
            echo 'success';
        } else {
            echo "<script>console.log($testingOTP)</script>";
            echo 'failure';
        }
        exit;
    }

    if (isset($_POST['submit_user'])) {
        $phone = $_POST['phone'];

        // Check if the phone number already exists in the database
        $check_sql = "SELECT * FROM users WHERE phone_number = '$phone'";
        $check_result = $conn->query($check_sql);

        if ($check_result->num_rows > 0) {
            // User found, store session data
            $user = $check_result->fetch_assoc();

            // Set session variable
            $_SESSION['user_id'] = $user['phone_number'];
        } else {
            // If the phone number does not exist, insert into the database
            $insert_sql = "INSERT INTO users (phone_number) VALUES ('$phone')";
            if ($conn->query($insert_sql) === TRUE) {

                // User found, store session data
                $user = $check_result->fetch_assoc();

                // Set session variable
                $_SESSION['user_id'] = $user['phone_number'];
            } else {
                echo "<script type='text/javascript'>
                        alert('Error: " . $insert_sql . " - " . $conn->error . "');
                      </script>";
            }
        }

        $conn->close();
    }
}
?>

<nav class="navbar position-fixed w-100 top-0 navbar-expand-md px-1 px-sm-2 px-md-3" style="z-index: 1; background-color: #e9ecef;">
    <div class="container-fluid">
        <!-- Mobile View: Hamburger Menu -->
        <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Logo -->
        <a class="navbar-brand mx-auto d-md-none" href="/car-express/public/home">
            <img src="../assets/images/logo/logo.PNG" alt="Logo" style="height: 40px;">
        </a>

        <!-- Right Side (S button & Profile) for Mobile -->
        <div class="d-flex d-md-none align-items-center">
            <!-- Grouped Dropdown -->



        </div>

        <!-- Large Screen Navbar -->
        <div class="collapse navbar-collapse py-2" id="navbarNav">
            <div class="d-md-flex align-items-center justify-content-between w-100">
                <!-- Logo -->
                <div style="width:10%; margin-right: 15px;" class="d-none d-md-block">
                    <a href="/car-express/public/home">
                        <img src="../assets/images/logo/logo.PNG" class="w-100" alt="Logo" class="me-2">
                    </a>
                </div>

                <!-- Select City -->
                <div style="width: 20%; position: relative;" class="d-none d-md-block">
                    <?php
                    // Get the selected city from URL
                    $selectedCity = isset($_GET['location']) ? htmlspecialchars($_GET['location']) : "";
                    ?>

                    <input type="text" id="citySearch" class="form-control" placeholder="Search City..." value="<?php echo $selectedCity; ?>" autocomplete="off">

                    <!-- Grouped Dropdown -->
                    <select class="form-select mt-1" id="citySelect" size="4"
                        style="outline:0; max-height: 200px; overflow-y: auto; display: none; 
                            position: absolute; width: 100%; z-index: 1000; background: white;">
                        <?php foreach ($states as $state => $cities): ?>
                            <!-- <optgroup label="<?= ucwords($state); ?>"> -->
                            <?php foreach ($cities as $city): ?>
                                <option class='py-2' value="<?= htmlspecialchars($city); ?>">
                                    <?= ucwords("$city, $state"); ?>
                                </option>
                            <?php endforeach; ?>
                            </optgroup>
                        <?php endforeach; ?>
                    </select>
                </div>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        let citySearch = document.getElementById("citySearch");
                        let citySelect = document.getElementById("citySelect");

                        // Show dropdown when input is focused
                        citySearch.addEventListener("focus", function() {
                            citySelect.style.display = "block";
                        });

                        // Hide dropdown when clicking outside
                        document.addEventListener("click", function(event) {
                            if (!citySearch.contains(event.target) && !citySelect.contains(event.target)) {
                                citySelect.style.display = "none";
                            }
                        });

                        // Filter cities dynamically
                        citySearch.addEventListener("input", function() {
                            let searchValue = citySearch.value.toLowerCase();
                            let options = citySelect.options;

                            for (let i = 0; i < options.length; i++) {
                                let city = options[i].value.toLowerCase();
                                options[i].style.display = city.includes(searchValue) ? "block" : "none";
                            }
                        });

                        // When selecting a city, update input and redirect
                        citySelect.addEventListener("change", function() {
                            let selectedCity = citySelect.value;
                            citySearch.value = selectedCity;
                            citySelect.style.display = "none"; // Hide dropdown

                            if (!selectedCity) return;

                            let currentUrl = window.location.href;
                            let newUrl;

                            if (currentUrl.includes("/products")) {
                                // If already on /products, update the location parameter
                                let url = new URL(currentUrl);
                                url.searchParams.set("location", selectedCity);
                                newUrl = url.toString();
                            } else {
                                // If not on /products, redirect to /products with the location parameter
                                newUrl = "/car-express/public/products?location=" + encodeURIComponent(selectedCity);
                            }

                            window.location.href = newUrl; // Reload the page with the updated URL



                        });
                    });
                </script>







                <!-- Search bar -->
                <div class="text-center" style="width:30%;" class="d-none d-md-block">
                    <form class="d-flex align-items-center">
                        <input type="text" id="searchInput" placeholder="Search here..." class="search-input" required>
                        <button type="button" class="input-group-txt search-button" id="searchButton">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <!-- Display Selected Language -->
                    <div title="Your preferred languge">
                        <?php echo htmlspecialchars($preferredLanguage); ?>
                    </div>

                    <!-- Wishlist -->
                    <div>
                        <a href="/car-express/public/wishlist" title="Wishlist" class="mx-2 mt-2 text-dark"><i class="bi bi-heart"></i></a>
                    </div>

                    <!-- Chat -->
                    <div>
                        <a href="/car-express/public/chat" title="Chat" class="mx-2 text-dark"><i class="bi bi-chat"></i></a>
                    </div>

                    <!-- Profile or Login Button -->
                    <?php if ($userId): ?>
                        <!-- Profile Dropdown -->
                        <div class="dropdown">
                            <button class="dropdown-toggle bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border:none;">
                                <a href="/car-express/public/profile" class="rounded-circle bg-danger text-white" style="padding: 9px 12px 9px 15px; text-decoration:none;">
                                    S
                                </a>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/car-express/public/profile">User Profile</a></li>
                                <li><a class="dropdown-item" href="#">Another Action</a></li>
                                <li><a class="dropdown-item" href="#">Something Else Here</a></li>
                                <li><a class="dropdown-item text-danger" href="/car-express/public/logout">Logout</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <!-- Login Button -->
                        <div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModalTest">
                                Login
                            </button>

                            <!-- Modal Structure -->
                            <div class="modal fade" id="loginModalTest" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body p-0">


                                            <!-- Right Panel Content (Login Form) -->
                                            <div class="">
                                                <!-- Close Button positioned at top-right -->
                                                <button type="button" class="btn-close position-absolute top-0 end-0 m-3"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                <div class=" p-4 ">

                                                    <h4 class="text-center">Login to continue</h4>

                                                    <div id="mobile-login">
                                                        <form method="POST">
                                                            <div class="my-3 gap-2 d-flex">
                                                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number" required>
                                                            </div>
                                                            <button type="button" id="sendOtpBtn" class="btn btn-primary mt-2">Send OTP</button>

                                                            <div id="otpSection" class="my-3" style="display: none;">
                                                                <label for="otp" class="form-label">Enter the OTP you received on your mobile phone:</label>
                                                                <div class="d-flex gap-2">
                                                                    <input type="text" class="form-control" id="otp" aria-describedby="otpHelp" placeholder="Enter OTP">
                                                                    <button type="button" id="verifyOtpBtn" class="btn btn-success">Verify OTP</button>
                                                                </div>
                                                            </div>
                                                            <button type="submit" id="loginUser" name="submit_user" class="mt-3 btn btn-success w-100" disabled>Login</button>
                                                        </form>

                                                        <div class="line-with-text">
                                                            <span>OR</span>
                                                        </div>

                                                        <div onclick="showGoogleLogin()" class="d-flex justify-content-center gap-3 p-3 align-items-center"
                                                            style="box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
                                                            <div>
                                                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="18px" height="18px"
                                                                    viewBox="0 0 48 48" class="abcRioButtonSvg">
                                                                    <g>
                                                                        <path fill="#EA4335"
                                                                            d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z">
                                                                        </path>
                                                                        <path fill="#4285F4"
                                                                            d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z">
                                                                        </path>
                                                                        <path fill="#FBBC05"
                                                                            d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z">
                                                                        </path>
                                                                        <path fill="#34A853"
                                                                            d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z">
                                                                        </path>
                                                                        <path fill="none" d="M0 0h48v48H0z"></path>
                                                                    </g>

                                                                </svg>
                                                            </div>
                                                            <div>Login with google</div>
                                                        </div>
                                                    </div>

                                                    <div id="google-login">
                                                        <p>Google login configuration</p>

                                                        <div class="line-with-text">
                                                            <span>OR</span>
                                                        </div>

                                                        <div onclick="showMobileLogin()" class="d-flex justify-content-center gap-3 p-3 align-items-center"
                                                            style="box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
                                                            <div>
                                                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="18px" height="18px"
                                                                    viewBox="0 0 48 48" class="abcRioButtonSvg">
                                                                    <g>
                                                                        <path fill="#EA4335"
                                                                            d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z">
                                                                        </path>
                                                                        <path fill="#4285F4"
                                                                            d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z">
                                                                        </path>
                                                                        <path fill="#FBBC05"
                                                                            d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z">
                                                                        </path>
                                                                        <path fill="#34A853"
                                                                            d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z">
                                                                        </path>
                                                                        <path fill="none" d="M0 0h48v48H0z"></path>
                                                                    </g>

                                                                </svg>
                                                            </div>
                                                            <div>Login with Mobile Number</div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    document.getElementById("google-login").style.display = "none";
                                    let otpVerified = false;

                                    function startCountdown() {
                                        let countdown = 30;
                                        const sendOtpBtn = document.getElementById("sendOtpBtn");

                                        sendOtpBtn.textContent = `Resend OTP (${countdown}s)`;
                                        sendOtpBtn.disabled = true;

                                        const countdownInterval = setInterval(() => {
                                            countdown--;
                                            sendOtpBtn.textContent = `Resend OTP (${countdown}s)`;

                                            if (countdown < 0) {
                                                clearInterval(countdownInterval);
                                                sendOtpBtn.textContent = "Resend OTP";
                                                sendOtpBtn.disabled = false;
                                            }
                                        }, 1000);
                                    }

                                    function showMobileLogin() {
                                        document.getElementById("mobile-login").style.display = "block";
                                        document.getElementById("google-login").style.display = "none";
                                    }

                                    function showGoogleLogin() {
                                        document.getElementById("mobile-login").style.display = "none";
                                        document.getElementById("google-login").style.display = "block";
                                    }

                                    document.getElementById("sendOtpBtn").addEventListener("click", function(event) {
                                        event.preventDefault();

                                        console.log("Send OTP button clicked");

                                        const phone = document.getElementById("phone").value;
                                        if (phone) {
                                            fetch("", {
                                                    method: "POST",
                                                    headers: {
                                                        "Content-Type": "application/x-www-form-urlencoded"
                                                    },
                                                    body: new URLSearchParams({
                                                        send_otp: true,
                                                        phone: phone
                                                    })
                                                })
                                                .then(response => response.text())
                                                .then(data => {
                                                    alert("OTP sent to " + phone);
                                                    document.getElementById("sendOtpBtn").disabled = true;
                                                    document.getElementById("phone").readOnly = true;
                                                    document.getElementById("otpSection").style.display = "block";
                                                    startCountdown();
                                                })
                                                .catch(error => console.error("Error:", error));
                                        } else {
                                            alert("Please enter a valid phone number.");
                                        }
                                    });

                                    document.getElementById("verifyOtpBtn").addEventListener("click", function(event) {
                                        event.preventDefault();

                                        console.log("Verify OTP button clicked");

                                        const otp = document.getElementById("otp").value;
                                        if (otp) {
                                            fetch("", {
                                                    method: "POST",
                                                    headers: {
                                                        "Content-Type": "application/x-www-form-urlencoded"
                                                    },
                                                    body: new URLSearchParams({
                                                        verify_otp: true,
                                                        otp: otp
                                                    })
                                                })
                                                .then(response => response.text())
                                                .then(data => {
                                                    if (data.trim() === "success") {
                                                        alert("OTP Verified Successfully!");
                                                        otpVerified = true;
                                                        document.getElementById("sendOtpBtn").style.display = "none";
                                                        document.getElementById("otpSection").style.display = "none";
                                                        document.getElementById("phone").readOnly = true;
                                                        document.getElementById("loginUser").disabled = false;
                                                    } else {
                                                        alert("Invalid OTP. Please try again.");
                                                    }
                                                })
                                                .catch(error => console.error("Error:", error));
                                        } else {
                                            alert("Please enter the OTP.");
                                        }
                                    });
                                });
                            </script>
                        </div>
                    <?php endif; ?>




                    <!-- Sell Button -->
                    <button class="sell-btn d-none d-md-block"><a href="/car-express/public/sell" style="text-decoration:none;" class="text-light">+ SELL</a></button>
                </div>
            </div>
        </div>
    </div>
</nav>