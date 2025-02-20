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
    <title>Admin Login</title>
</head>
<body>
    <h2>Admin Login</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="identifier" placeholder="Email or Phone" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
