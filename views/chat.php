<?php
// Fetch product details based on product_id
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 38;

$productQuery = "SELECT product_name, price,product_image image FROM products WHERE product_id = ?";
$stmt = $conn->prepare($productQuery);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$productResult = $stmt->get_result();
$product = $productResult->fetch_assoc();
echo $product['product_image'];
// Check if product_image exists and is not empty
if (!empty($product['product_image'])) {
    // Explode the string and get the first image
    $images = explode(',', $product['product_image']);
    if (count($images) == 0) {
        $firstImage = $product['product_image'];
    }
    $firstImage = trim($images[0]); // Ensure no whitespace issues
} else {
    // Fallback to a default image if no image is available
    $firstImage = '../assets/images/profile/no-profile.jpg';
}
?>

<style>
    .chat-container {
        max-height: 80vh;
        height: 80vh;
        /* min-height: 50vh; */
        display: flex;
        border: 1px solid #ccc;
        border-radius: 10px;
        overflow: hidden;
    }

    .user-list {
        width: 100%;
        max-width: 300px;
        background: #e9ecef;
        padding: 15px;
        border-right: 1px solid #ddd;
        overflow-y: auto;
    }



    .chat-box {
        flex: 1;
        display: flex;
        flex-direction: column;
        /* display: none; */
        /* Hidden on mobile initially */
    }

    .product-info {
        background: #e9ecef;
        padding: 10px;
        border-bottom: 1px solid #ddd;
        display: flex;
        align-items: center;
    }

    .product-info img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 5px;
        margin-right: 10px;
    }

    .chat-messages {
        flex: 1;
        padding: 15px;
        overflow-y: auto;
        background: #fff;
    }

    .chat-input {
        border-top: 1px solid #ddd;
        padding: 10px;
        background: #f8f9fa;
    }

    .message {
        padding: 10px;
        border-radius: 10px;
        margin-bottom: 10px;
        max-width: 70%;
    }

    .sent {
        background-color: #007bff;
        color: white;
        align-self: flex-end;
    }

    .received {
        background-color: #f1f1f1;
        align-self: flex-start;
    }

    .back-btn {
        display: none;
    }

    @media (max-width: 768px) {
        .user-list {
            max-width: 100%;
            width: 100%;
        }

        .chat-box {
            width: 100%;
            display: none;
        }

        .back-btn {
            display: block;
        }
    }
</style>

<div class="container-fluid mt-0 mt-sm-0">
    <div class="chat-container">
        <!-- User List -->
        <div class="user-list" id="userList">
            <h5 class="text-center">Your Chats</h5>
            <ul class="list-unstyled">
                <li class="p-3 border-bottom user-item" data-user="9876543211">User 1</li>
                <li class="p-3 border-bottom user-item" data-user="9876543212">User 2</li>
                <li class="p-3 border-bottom user-item" data-user="9876543213">User 3</li>
            </ul>
        </div>

        <!-- Chat Box -->
        <div class="chat-box " id="chatBox">



            <div class="product-info">
                <img src="<?php echo htmlspecialchars($firstImage); ?>" alt="Product">
                <div>
                    <strong><?php echo htmlspecialchars($product['product_name'] ?? 'Unknown Product'); ?></strong><br>
                    <span>$<?php echo number_format($product['price'] ?? 0, 2); ?></span>
                </div>
            </div>

            <div class="mx-2 mx-sm-0">
                <div class="chat-messages d-flex flex-column" id="chatMessages">
                    <?php foreach ($messages as $msg): ?>
                        <div class="message <?php echo ($msg['sender_id'] == $sender_id) ? 'sent' : 'received'; ?>">
                            <strong>User <?php echo $msg['sender_id']; ?>:</strong> <?php echo htmlspecialchars($msg['message']); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <form method="POST" class="chat-input d-flex">
                    <input type="hidden" name="sender_id" value="<?php echo $sender_id; ?>">
                    <input type="hidden" name="receiver_id" id="receiver_id" value="<?php echo $receiver_id; ?>">
                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                    <input type="text" class="form-control me-2" name="message" placeholder="Type a message..." required>
                    <button type="submit" class="btn btn-primary">Send</button>
                </form>

                <button class="back-btn my-2 btn btn-primary w-100" onclick="goBack()">Back to Users</button>
            </div>
        </div>
    </div>
</div>

<script>
    function goBack() {
        document.getElementById("chatBox").style.display = "none";
        document.getElementById("userList").style.display = "block";
    }

    if (window.innerWidth <= 767) {
        document.querySelectorAll('.user-item').forEach(item => {
            item.addEventListener('click', function() {
                let userId = this.getAttribute('data-user');
                document.getElementById("receiver_id").value = userId;

                document.getElementById("userList").style.display = "none";
                document.getElementById("chatBox").style.display = "block";
            });
        });
    }
</script>






















<!-- Agar sender ki koi chat present nahi hai tab ye chaley -->




<div class="d-flex d-none flex-column justify-content-center align-items-center text-center my-5">
    <div class="text-center my-5">
        <p class="fw-bold text-muted fs-5">No messages yet</p>
        <div class="mb-3">
            <img src="../assets/images/chat/emptyChat.jpg" draggable="false" alt="No message" class="img-fluid" style="max-width: 250px; opacity: 0.8;" />
        </div>
        <div class="text-muted fs-6">We’ll keep messages for any item you’re selling in here.</div>
    </div>
</div>