<?php
// Fetch the location information from the database
$cityResult = $conn->query("SELECT * FROM location_city LIMIT 6");
$stateResult = $conn->query("SELECT * FROM location_state LIMIT 6");

$cities = [];
$states = [];

if ($stateResult->num_rows > 0) {
    while ($row = $stateResult->fetch_assoc()) {
        $states[] = $row["state_name"];
    }
}

if ($cityResult->num_rows > 0) {
    while ($row = $cityResult->fetch_assoc()) {
        $cities[] = $row['city_name'];  // Store city names
    }
}
?>

<footer class="footer mt-auto mt-5">

    <!-- Top Desktop footer -->
    <div class="bg-dark py-3 pt-4">
        <div class="container">
            <div class="row">
                <!-- Location Column -->
                <div class="col-md-3 col-6">
                    <h5>City</h5>
                    <ul style="list-style:none;" class="px-0 mb-3">
                        <?php
                        if (!empty($cities)) {
                            foreach ($cities as $city) {
                                echo "<li class='text-left city-item' style='cursor:pointer;' data-city='" . htmlspecialchars($city) . "'>" . htmlspecialchars($city) . "</li>";
                            }
                        } else {
                            echo "<li>No locations found</li>";
                        }
                        ?>
                    </ul>

                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            document.querySelectorAll(".city-item").forEach(item => {
                                item.addEventListener("click", function() {
                                    let city = this.getAttribute("data-city");
                                    let currentUrl = window.location.href;
                                    let newUrl;

                                    if (currentUrl.includes("/products")) {
                                        // If already on /products, just update the location parameter
                                        let url = new URL(currentUrl);
                                        url.searchParams.set("location", city);
                                        newUrl = url.toString();
                                    } else {
                                        // If not on /products, redirect to /products with the location parameter
                                        newUrl = "/car-express/public/products?location=" + encodeURIComponent(city);
                                    }

                                    window.location.href = newUrl;
                                });
                            });
                        });
                    </script>
                </div>

                <!-- Trending Locations -->
                <div class="col-md-3 col-6">
                    <h5>Trending Locations</h5>
                    <ul style="list-style:none;" class="px-0">
                        <?php
                        if (!empty($states)) {
                            foreach ($states as $state) {
                                echo "<li class='text-left city-item' style='cursor:pointer;' data-city='" . htmlspecialchars($state) . "'>" . htmlspecialchars($state) . "</li>";
                            }
                        } else {
                            echo "<li>No locations found</li>";
                        }
                        ?>
                    </ul>
                </div>

                <!-- Car Express -->
                <div class="col-md-3 col-6">
                    <h5>Car Express</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">About Us</a></li>
                        <li><a href="#" class="text-white">Sell Your Car</a></li>
                        <li><a href="#" class="text-white">Buy Cars</a></li>
                        <li><a href="#" class="text-white">Finance</a></li>
                        <li><a href="#" class="text-white">Contact</a></li>
                    </ul>
                </div>

                <!-- Follow Us -->
                <div class="col-md-3 col-6">
                    <h5>Follow Us</h5>
                    <ul class="list-unstyled">
                        <li><a href="https://wa.me/1234567890" class="text-white">WhatsApp</a></li>
                        <li><a href="mailto:support@carexpress.com" class="text-white">Email Us</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fetching location and trending locations from database via PHP & AJAX
        fetch('fetch_location.php')
            .then(response => response.json())
            .then(data => {
                document.getElementById('user-location').innerText = data.city_name || 'Location not available';
                const trendingList = document.getElementById('trending-locations');
                trendingList.innerHTML = data.trending_states.map(state => `<li>${state}</li>`).join('');
            })
            .catch(() => {
                document.getElementById('user-location').innerText = 'Error fetching location';
            });
    </script>

    <div class="py-3 px-3  ">
        <div class="container text-center">
            <!-- Logos in a single line -->
            <div class="row justify-content-center mb-3">
                <div class="col-12 logos">
                    <div class="d-flex justify-content-between">
                        <div>
                            <img src="../image.jpg" style="height: 3rem; width:3rem;" alt="CarTradeTech Logo">
                        </div>
                        <div>
                            <div class="col-4">
                                <img src="../image.jpg" style="height: 3rem; width:3rem;" alt="OLX Logo">
                            </div>
                            <div class="col-4">
                                <img src="../image.jpg" style="height: 3rem; width:3rem;" alt="CarWale Logo">
                            </div>
                            <div class="col-4">
                                <img src="../image.jpg" style="height: 3rem; width:3rem;" alt="BikeWale Logo">
                            </div>
                            <div class="col-4">
                                <img src="../image.jpg" style="height: 3rem; width:3rem;" alt="CarTrade Logo">
                            </div>
                            <div class="col-4">
                                <img src="../image.jpg" style="height: 3rem; width:3rem;" alt="Mobility Outlook Logo">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer text in a single line -->
        <div class="row">
            <div class="col-12 bottom-text">
                <div class="d-flex justify-content-between">
                    <div>
                        <a href="#">Help</a> |
                        <a href="#">Sitemap</a> |
                    </div>
                    <div>
                        <span>All rights reserved © 2006-2025 OLX</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
                        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>


        </body>
        </html>