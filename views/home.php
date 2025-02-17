<!-- Blank page -->
<div class="container-fluid my-2 px-sm-4 px-2">
    <div class="homepage-first-div bg-light">
        <img src="../assets/images/banner/banner.png" draggable="false" alt="Banner" class="img-fluid h-100 w-100 object-fit-cover" />
    </div>
</div>

<!-- Fresh Products Section -->
<div class="container">
    <h4 class="mb-4 mt-5">Fresh recommendations</h4>

    <div class="container">
        <?php 
        $query = "SELECT product_id, product_image, price, created_at, product_name AS title, location AS address 
        FROM products 
        ORDER BY created_at DESC";
        require_once __DIR__ . '/sections/productCard.php'; ?>

        <!-- Load More Button -->
        <!-- <div class="text-center mt-4">
            <button class="btn btn-primary" id="loadMore">Load More</button>
        </div> -->
    </div>
</div>