<?php
// Sample Data
$product = [
    "name" => "Honda City ZX",
    "price" => "₹10,50,000",
    "year" => "2021",
    "km" => "25,000 KM",
    "fuel" => "Petrol",
    "transmission" => "Automatic",
    "owner" => "First Owner",
    "location" => "Mumbai, Maharashtra",
    "description" => "The Honda City ZX is a premium sedan offering comfort, fuel efficiency, and advanced features. It comes with a sunroof, leather seats, and cruise control, making it a great choice for city and highway driving."
];
?>

<div class="container mt-4">
    <div class="card p-4">
        <h4 class="mb-3"><?php echo $product['name']; ?></h4>

        <!-- Details Section -->
        <div class="details-section">
            <div class="row">
                <div class="col-md-3">
                    <strong>Price:</strong> <?php echo $product['price']; ?>
                </div>
                <div class="col-md-3">
                    <strong>Year:</strong> <?php echo $product['year']; ?>
                </div>
                <div class="col-md-3">
                    <strong>KM Driven:</strong> <?php echo $product['km']; ?>
                </div>
                <div class="col-md-3">
                    <strong>Fuel Type:</strong> <?php echo $product['fuel']; ?>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-3">
                    <strong>Transmission:</strong> <?php echo $product['transmission']; ?>
                </div>
                <div class="col-md-3">
                    <strong>Owner:</strong> <?php echo $product['owner']; ?>
                </div>
                <div class="col-md-6">
                    <strong>Location:</strong> <?php echo $product['location']; ?>
                </div>
            </div>
        </div>

        <!-- Description Section -->
        <div class="description-section">
            <h5>Description</h5>
            <p><?php echo $product['description']; ?></p>
        </div>
    </div>
</div>