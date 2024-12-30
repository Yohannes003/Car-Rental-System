<?php
include("includes/connection.php"); // Include database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['operation'])) {
    if ($_POST['operation'] === 'add_or_edit') {
        // Extract and sanitize input data
        $car_year = intval($_POST['car_year']);
        $car_name = htmlspecialchars($_POST['car_name']);
        $price_per_day = floatval($_POST['price_per_day']);
        $car_image = $_FILES['car_image']['name'];
        $target_dir = "img/";
        $target_file = $target_dir . basename($car_image);
        $is_edit = isset($_POST['id']); // Determine if this is an edit operation

        if ($is_edit) {
            $car_id = intval($_POST['id']);
            if (!empty($car_image) && move_uploaded_file($_FILES['car_image']['tmp_name'], $target_file)) {
                // Update car with a new image
                $update_car = "UPDATE cars SET car_year = ?, car_name = ?, price_per_day = ?, car_image = ? WHERE id = ?";
                $stmt = $con->prepare($update_car);
                $stmt->bind_param("isisi", $car_year, $car_name, $price_per_day, $car_image, $car_id);
            } else {
                // Update car without changing the image
                $update_car = "UPDATE cars SET car_year = ?, car_name = ?, price_per_day = ? WHERE id = ?";
                $stmt = $con->prepare($update_car);
                $stmt->bind_param("isis", $car_year, $car_name, $price_per_day, $car_id);
            }
            // Execute update query
            if ($stmt->execute()) {
                echo "<script>alert('Car updated successfully!'); window.location.href = 'caradmin.php';</script>";
            } else {
                echo "<script>alert('Failed to update car.');</script>";
            }
        } else {
            if (move_uploaded_file($_FILES['car_image']['tmp_name'], $target_file)) {
                // Insert a new car record
                $insert_car = "INSERT INTO cars (car_year, car_name, price_per_day, car_image) VALUES (?, ?, ?, ?)";
                $stmt = $con->prepare($insert_car);
                $stmt->bind_param("isis", $car_year, $car_name, $price_per_day, $car_image);
                if ($stmt->execute()) {
                    echo "<script>alert('Car added successfully!'); window.location.href = 'caradmin.php';</script>";
                } else {
                    echo "<script>alert('Failed to add car.');</script>";
                }
            } else {
                echo "<script>alert('Failed to upload image.');</script>";
            }
        }
    }
}
?>