<?php
    elseif ($_POST['operation'] === 'approve') {
        // Approve car rental
        $car_id = intval($_POST['car_id']);
        $update_status = "UPDATE cars SET rental_status = 'rented' WHERE id = ?";
        $stmt = $con->prepare($update_status);
        $stmt->bind_param("i", $car_id);
        if ($stmt->execute()) {
            echo "<script>alert('Rental approved successfully!'); window.location.href = 'caradmin.php';</script>";
        } else {
            echo "<script>alert('Failed to approve rental.');</script>";
        }
    }
} elseif (isset($_GET['delete'])) {
    // Delete a car record
    $car_id = intval($_GET['delete']);
    $query = "SELECT car_image FROM cars WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $car_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $car = $result->fetch_assoc();

    if ($car) {
        $image_path = "img/" . $car['car_image'];
        if (file_exists($image_path)) {
            unlink($image_path); // Remove the image file
        }
        $delete_query = "DELETE FROM cars WHERE id = ?";
        $stmt = $con->prepare($delete_query);
        $stmt->bind_param("i", $car_id);
        if ($stmt->execute()) {
            echo "<script>alert('Car deleted successfully!'); window.location.href = 'caradmin.php';</script>";
        } else {
            echo "<script>alert('Failed to delete car.');</script>";
        }
    }
}
?>
