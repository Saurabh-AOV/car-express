<?php
session_start();
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = $_POST['identifier']; // Can be phone or email
    $password = $_POST['password'];

    // Check if it's a phone or email
    if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
        $query = "SELECT * FROM admins WHERE email = ? LIMIT 1";
    } else {
        $query = "SELECT * FROM admins WHERE phone = ? LIMIT 1";
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $identifier);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_name'] = $user['name'];
            $_SESSION['admin_phone'] = $user['phone'];
            $_SESSION['admin_email'] = $user['email'];
            
            header("Location: ../dashboard.php");
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "No admin found with this email or phone!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4 col-sm-8 col-10">
                <div class="card shadow-sm p-4">
                    <h2 class="text-center">Admin Login</h2>
                    <?php if (isset($error)) echo "<p class='text-danger text-center'>$error</p>"; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <input type="text" name="identifier" class="form-control" placeholder="Email or Phone" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="./reset-password.php" class="text-primary nav-link">Reset</a> Password if you forget
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
