<?php 
// Convert string to array
$images = array_map('trim', explode(",", $imagesString));
?>

<div class="container-fluid">
    <div class="slider-container">
        <!-- Left Button -->
        <button class="prev" onclick="changeImage(-1)">❮</button>

        <!-- Main Large Image (Set first image dynamically) -->
        <img id="mainImage" src="<?php echo !empty($images) ? $images[0] : '../default.jpg'; ?>" class="main-image">

        <!-- Right Button -->
        <button class="next" onclick="changeImage(1)">❯</button>
    </div>

    <!-- Thumbnail Images -->
    <div class="mt-3 d-flex justify-content-between gap-2">
    <?php foreach ($images as $index => $image): ?>
            <img src="<?php echo $image; ?>" class="thumbnail <?php echo $index === 0 ? 'active' : ''; ?>" onclick="setMainImage('<?php echo $image; ?>', this)">
        <?php endforeach; ?>
    </div>
</div>

<!-- JavaScript for Image Switching -->
<script>
    // Image slider
let currentIndex = 0;
    let images = <?php echo json_encode($images); ?>;

    function setMainImage(image, element) {
        document.getElementById("mainImage").src = image;
        document.querySelectorAll(".thumbnail").forEach(img => img.classList.remove("active"));
        element.classList.add("active");
    }

    function changeImage(direction) {
        currentIndex += direction;
        if (currentIndex < 0) currentIndex = images.length - 1;
        if (currentIndex >= images.length) currentIndex = 0;

        let newImage = images[currentIndex];
        document.getElementById("mainImage").src = newImage;

        document.querySelectorAll(".thumbnail").forEach(img => img.classList.remove("active"));
        document.querySelectorAll(".thumbnail")[currentIndex].classList.add("active");
    }
</script>