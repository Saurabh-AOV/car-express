<?php
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = $_POST['identifier'];
    $newPassword = $_POST['new_password'];

    // Password strength validation
    if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $newPassword)) {
        $error = "Password must be at least 8 characters long and include one uppercase letter, one lowercase letter, one number, and one special character.";
    } else {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        // Check if it's email or phone
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $query = "SELECT * FROM admins WHERE email = ? LIMIT 1";
            $updateQuery = "UPDATE admins SET password = ? WHERE email = ?";
        } else {
            $query = "SELECT * FROM admins WHERE phone = ? LIMIT 1";
            $updateQuery = "UPDATE admins SET password = ? WHERE phone = ?";
        }

        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $identifier);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            // Update password
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("ss", $hashedPassword, $identifier);
            
            if ($stmt->execute()) {
                $success = "Password updated successfully!";
            } else {
                $error = "Error updating password!";
            }
        } else {
            $error = "No admin found with this email or phone!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>
    <form method="POST">
        <input type="text" name="identifier" placeholder="Enter Email or Phone" required><br>
        <input type="password" name="new_password" placeholder="New Password" required><br>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
