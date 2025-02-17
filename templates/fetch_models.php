<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $manufacturer = $_POST['car_manufacturer'];
    
    $sql = "SELECT DISTINCT car_model FROM car_category_info WHERE car_manufacturer='$manufacturer'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<li class='list-group-item'>" . $row['car_model'] . "</li>";
        }
    } else {
        echo "<li class='list-group-item text-danger'>No Models Available</li>";
    }
}
?>
