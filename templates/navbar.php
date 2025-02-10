<?php
// Fomating text
require_once __DIR__ . "/../app/helpers/FormatingTextHelper.php";

// Fetch city data
$cityQuery = "SELECT id, city_name FROM city";
$citiesResult = $conn->query($cityQuery);

// Fetch language data
$languageQuery = "SELECT language_id, language_name FROM languages";
$languageResult = $conn->query($languageQuery);
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
                <div style="width:20%;" class="d-none d-md-block">
                    <select class="form-select" id="citySelect" style="outline:0;">
                        <option value="">Select City</option>
                        <?php
                        if ($citiesResult->num_rows > 0) {
                            while ($row = $citiesResult->fetch_assoc()) {
                                echo "<option value='" . strtolower($row['city_name']) . "'>" . capitalize_first($row['city_name']) . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

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

                    <!-- Profile Dropdown -->
                    <div class="dropdown">
                        <button class="dropdown-toggle bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border:none;">
                            <a class="rounded-circle bg-danger text-white" style="padding: 9px 12px 9px 15px; text-decoration:none;">
                                S
                            </a>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </div>

                    <!-- Sell Button -->
                    <button class="sell-btn d-none d-md-block">+ SELL</button>
                </div>
            </div>
        </div>
    </div>
</nav>