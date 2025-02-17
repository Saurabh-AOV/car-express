<?php
// Fomating text
require_once __DIR__ . "/../app/helpers/FormatingTextHelper.php";

// Fetch city data
$cityQuery = "SELECT city_id, city_name FROM location_city";
$citiesResult = $conn->query($cityQuery);

// Fetch language data
$languageQuery = "SELECT language_id, language_name FROM languages";
$languageResult = $conn->query($languageQuery);
?>

<!-- Login -->
<?php
session_start();

// Connect config file
include '../../admin/config/db_connect.php';

// Check if the user is logged in via session
if (isset($_SESSION['user_id'])) {

    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : $_COOKIE['user_id'];

    if ($user_id) {
        $check_result = $conn->query("SELECT * FROM users WHERE phone_number = $user_id");

        if ($check_result->num_rows == 1) {
            header("Location: dashboard.php");
            exit; // Always exit after header redirect
        }
    }
}

// Replace with your Fast2SMS API key
$api_key = "2lEn0Mrzdw35NIsJWaB4ZLjfRC6Fg8ueGTYb79VhKmHqSxo1OD6IwyLCeP3i02tqbfU85OBQlSWaFjHT";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['send_otp'])) {
        $phone = $_POST['phone'];
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['phone'] = $phone;

        $api_url = "https://www.fast2sms.com/dev/bulkV2?authorization=$api_key&route=otp&variables_values=$otp&flash=0&numbers=$phone";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            echo "cURL Error: $error_msg";
            curl_close($ch);
            exit;
        }

        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_status === 200) {
            echo "OTP sent successfully.";
        } else {
            echo "Failed to send OTP.";
        }
        exit;
    }

    if (isset($_POST['verify_otp'])) {
        $entered_otp = $_POST['otp'];
        if ($_SESSION['otp'] == $entered_otp) {
            echo 'success';
        } else {
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

            // If the phone number exists, redirect to dashboard.php
            header("Location: dashboard.php");
        } else {
            // If the phone number does not exist, insert into the database
            $insert_sql = "INSERT INTO users (phone_number) VALUES ('$phone')";
            if ($conn->query($insert_sql) === TRUE) {

                // User found, store session data
                $user = $check_result->fetch_assoc();

                // Set session variable
                $_SESSION['user_id'] = $user['phone_number'];

                // After inserting, redirect to dashboard.php
                header("Location: dashboard.php");
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


<nav class="navbar navbar-expand-md navbar-light bg-light px-3">
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
            <a class="rounded-circle bg-danger text-white" style="padding: 9px 12px 9px 15px; text-decoration:none;">
                S
            </a>
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

                    <select class="form-select mt-1" id="citySelect" size="4"
                        style="outline:0; max-height: 200px; overflow-y: auto; display: none; 
               position: absolute; width: 100%; z-index: 1000; background: white;">
                        <?php
                        if ($citiesResult->num_rows > 0) {
                            while ($row = $citiesResult->fetch_assoc()) {
                                $cityName = htmlspecialchars($row['city_name']);
                                echo "<option class='py-2' value='$cityName'>" . ucwords($cityName) . "</option>";
                            }
                        }
                        ?>
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
                    <!-- Select language -->
                    <div>
                        <select class="form-select bg-transparent" id="languageSelect" style="outline:0; border:0;">
                            <?php
                            $selectedLanguage = "English";
                            if ($languageResult->num_rows > 0) {
                                while ($row = $languageResult->fetch_assoc()) {
                                    $selected = ($row['language_name'] === $selectedLanguage) ? "selected" : "";
                                    echo "<option value='" . htmlspecialchars($row['language_id']) . "' $selected>" . htmlspecialchars($row['language_name']) . "</option>";
                                }
                            }
                            ?>
                        </select>

                    </div>

                    <!-- Wishlist -->
                    <div>
                        <a href="/car-express/public/wishlist" class="mx-2 mt-2 text-dark"><i class="bi bi-heart"></i></a>
                    </div>

                    <!-- Chat -->
                    <div>
                        <a href="/car-express/public/chat" class="mx-2 text-dark"><i class="bi bi-chat"></i></a>
                    </div>

                    <?php
                    $userLoggedIn = isset($_COOKIE['user_id']); // Check if user_id cookie exists
                    ?>

                    <!-- Profile or Login Button -->
                    <?php if ($userLoggedIn): ?>
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
                                <li><a class="dropdown-item text-danger" href="/car-express/public/logout.php">Logout</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <!-- Login Button -->
                        <div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">
                                Login
                            </button>
                        </div>
                    <?php endif; ?>


                    <!-- Login Modal -->
                    <div>
                        <!-- Modal Structure -->
                        <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body p-0">
                                        <div class="d-flex">

                                            <!-- Right Panel Content (Login Form) -->
                                            <div class="col-lg-7 d-flex align-items-center justify-content-center">
                                                <!-- Close Button positioned at top-right -->
                                                <button type="button" class="btn-close position-absolute top-0 end-0 m-3"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                <div class=" p-4 " style="width: 400px;">

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

                                                    <div id="google-login" style="display:none;">
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
                        </div>
                        <script>
                            function startCountdown() {
                                var countdown = 30; // Set the countdown start value

                                // Create a function to update the button text with the countdown
                                var countdownInterval = setInterval(function() {
                                    $('#sendOtpBtn').text('Resend OTP (' + countdown + 's)');
                                    countdown--;

                                    // When countdown reaches 0, stop the interval and show the Resend OTP button
                                    if (countdown < 0) {
                                        clearInterval(countdownInterval);
                                        $('#sendOtpBtn').text('Resend OTP');
                                        $('#sendOtpBtn').prop('disabled', false);
                                    }
                                }, 1000);
                            }

                            function showMobileLogin() {
                                $('#mobile-login').show();
                                $('#google-login').hide();
                            }

                            function showGoogleLogin() {
                                $('#mobile-login').hide();
                                $('#google-login').show();
                            }

                            $(document).ready(function() {
                                let otpVerified = false;

                                $('#sendOtpBtn').click(function() {
                                    console.log("Send button clicked");

                                    const phone = $('#phone').val();
                                    if (phone) {
                                        $.post('', {
                                            send_otp: true,
                                            phone: phone
                                        }, function(response) {
                                            alert('OTP sent to ' + phone);
                                            $('#sendOtpBtn').prop('disabled', true);
                                            $('#phone').prop('readonly', true);
                                            $('#otpSection').show();

                                            // Start the countdown for Resend OTP button
                                            startCountdown();
                                        });
                                    } else {
                                        alert('Please enter a valid phone number.');
                                    }
                                });

                                $('#verifyOtpBtn').click(function() {
                                    const otp = $('#otp').val();
                                    if (otp) {
                                        $.post('', {
                                            verify_otp: true,
                                            otp: otp
                                        }, function(response) {
                                            if (response === 'success') {
                                                alert('OTP Verified Successfully!');
                                                otpVerified = true;
                                                $('#sendOtpBtn').hide();
                                                $('#otpSection').hide();
                                                $('#phone').prop('readonly', true);
                                                $('#loginUser').prop('disabled', false);
                                            } else {
                                                alert('Invalid OTP. Please try again.');
                                            }
                                        });
                                    } else {
                                        alert('Please enter the OTP.');
                                    }
                                });
                            });
                        </script>
                    </div>

                    <!-- Sell Button -->
                    <button class="sell-btn d-none d-md-block"><a href="/car-express/public/sell" style="text-decoration:none;" class="text-light">+ SELL</a></button>
                </div>
            </div>
        </div>
    </div>
</nav>