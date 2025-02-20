<?php
include '../includes/db.php';
$result = $conn->query("SELECT * FROM cars ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cars List</title>
</head>
<body>
    <h2>Cars List</h2>
    <a href="add_car.php">Add New Car</a>
    <table border="1">
        <tr>
            <th>Product ID</th>
            <th>Car Name</th>
            <th>Price</th>
            <th>Condition</th>
            <th>Year</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['product_id'] ?></td>
                <td><?= $row['product_name'] ?></td>
                <td><?= $row['price'] ?></td>
                <td><?= $row['product_condition'] ?></td>
                <td><?= $row['year_of_registration'] ?></td>
                <td>
                    <a href="view_car.php?id=<?= $row['product_id'] ?>">View</a> |
                    <a href="edit_car.php?id=<?= $row['product_id'] ?>">Edit</a> |
                    <a href="delete_car.php?id=<?= $row['product_id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
