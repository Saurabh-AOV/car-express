<div class="container-fluid mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/car-express/public/home" style="text-decoration:none;">Home</a></li>
            <li class="breadcrumb-item"><a href="#" style="text-decoration:none;">Cars</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data</li>
        </ol>
    </nav>

    <div class="product-container">
        <div class="d-flex w-100 product-detail-flex-column gap-2">
            <!-- <div style="width:70%;"> -->
            <div class="product-detail-left">
                <div class="product-img-section">
                    <?php
                    require_once __DIR__ . "/sections/product-detail-content/largeScreenProductImage.php";
                    ?>
                </div>

                <div class="product-details my-1 card px-3 py-3">
                    <h2 class=" mb-3">Description</h2>
                    <div>
                        I am the description what ever you type fetch here
                    </div>
                </div>

                <div class="product-details my-1 card px-3 py-4">
                    <h2 class=" mb-3">Additional information</h2>
                    <div>
                        I am the description what ever you type fetch here
                    </div>
                </div>
            </div>

            <!-- <div style="width:30%"> -->
            <div class="product-detail-right">
                <div class="card mb-2" style=" position: relative;">

                    <!-- Price card -->
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title"> ₹ 499</h5>
                            </div>
                            <div>
                                <button class="btn btn-sm mb-2" id="shareBtn"><i class="bi bi-share"></i></button>

                                <div id="shareOptions" class="mt-2" style="display: none;">
                                    <a href="https://api.whatsapp.com/send?text=Check%20this%20out!" class="btn btn-success btn-sm me-2" target="_blank">
                                        <i class="bi bi-whatsapp"></i> WhatsApp
                                    </a>
                                    <a href="mailto:?subject=Check%20this%20out&body=Here%20is%20something%20interesting!" class="btn btn-danger btn-sm">
                                        <i class="bi bi-envelope"></i> Email
                                    </a>
                                </div>

                                <script>
                                    $(document).ready(function() {
                                        $("#shareBtn").click(function() {
                                            $("#shareOptions").toggle(); // Show/Hide buttons
                                        });
                                    });
                                </script>
                                <button class="btn  btn-sm mb-2"><i class="bi bi-heart"></i></button>
                            </div>
                        </div>
                        <p>This is the tile of the product</p>

                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="card-subtitle mb-0 text-muted">Listed on: Feb 11, 2025</h6>
                            <p class="card-text">
                                <strong>5 day ago</strong>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- User profile -->
                <div class="product-details  card p-3 mb-2">
                    <div class="w-100 d-flex justify-content-between align-items-center">
                        <div class="d-flex gap-2 align-items-center">
                            <img src="../image.jpg" style="height: 4rem; width:4rem; border-radius: 50%;" alt="user profile" />
                            <h5 class="mb-0">User Profilename</h5>
                        </div>
                        <i class="bi bi-arrow-right-short" style="font-size:35px;"></i>
                    </div>

                    <button class="btn btn-success mt-3">Chat with seller</button>
                </div>

                <!-- Posted in -->
                <div class="product-details  card p-3 mb-2">
                    <h4 class=" mb-3">Posted in</h4>
                    <div>Here print the address of the product listing only</div>
                </div>

                <!-- Map -->
                <div class="product-details  card p-3 mb-2">
                    <!-- Embed Google Map inside the div -->
                    <iframe
                        width="100%"
                        height="300"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.012745268376!2d-122.08424998468224!3d37.42199977982513!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808fbb2d6a0a0b33%3A0x38c8e6c8de7271b!2sGoogleplex!5e0!3m2!1sen!2sus!4v1676110503341!5m2!1sen!2sus"
                        frameborder="0"
                        style="border:0;"
                        allowfullscreen=""
                        aria-hidden="false"
                        tabindex="0">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>