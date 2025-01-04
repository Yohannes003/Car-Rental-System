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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Cars</title>
    <style>
   
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            color: #444;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            font-size: 1rem;
            font-weight: bold;
        }
        input[type="text"], input[type="number"], input[type="file"] {
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
        }
        button {
            background: #007bff;
            color: #fff;
            padding: 10px 15px;
            font-size: 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">

        <h1><?= $car_to_edit ? 'Edit Car' : 'Add a New Car' ?></h1>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="operation" value="add_or_edit">
            <?php if ($car_to_edit): ?>
                <input type="hidden" name="id" value="<?= $car_to_edit['id'] ?>">
            <?php endif; ?>
            <label for="car_year">Car Year:</label>
            <input type="number" id="car_year" name="car_year" value="<?= $car_to_edit['car_year'] ?? '' ?>" required>

            <label for="car_name">Car Name:</label>
            <input type="text" id="car_name" name="car_name" value="<?= $car_to_edit['car_name'] ?? '' ?>" required>

            <label for="price_per_day">Price Per Day:</label>
            <input type="text" id="price_per_day" name="price_per_day" value="<?= $car_to_edit['price_per_day'] ?? '' ?>" required>

            <label for="car_image">Car Image:</label>
            <input type="file" id="car_image" name="car_image" accept="image/*">
            <?php if ($car_to_edit && $car_to_edit['car_image']): ?>
                <small>Leave blank to keep the current image.</small>
            <?php endif; ?>

            <button type="submit"><?= $car_to_edit ? 'Update Car' : 'Add Car' ?></button>
        </form>

        <h1>View All Cars</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Year</th>
                    <th>Name</th>
                    <th>Price/Day</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($car = $cars->fetch_assoc()): ?>
                    <tr>
                        <td><?= $car['id'] ?></td>
                        <td><?= $car['car_year'] ?></td>
                        <td><?= $car['car_name'] ?></td>
                        <td>$<?= $car['price_per_day'] ?></td>
                        <td><?= ucfirst($car['rental_status'] ?? 'available') ?></td>
                        <td>
                            <a href="?edit=<?= $car['id'] ?>">Edit</a> |
                            <a href="?delete=<?= $car['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h1>Approve Rentals</h1>
        <?php if ($pending_cars_result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Car Name</th>
                        <th>Year</th>
                        <th>Price/Day</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($car = $pending_cars_result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($car['car_name']) ?></td>
                            <td><?= htmlspecialchars($car['car_year']) ?></td>
                            <td>$<?= htmlspecialchars(number_format($car['price_per_day'], 2)) ?></td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="operation" value="approve">
                                    <input type="hidden" name="car_id" value="<?= $car['id'] ?>">
                                    <button type="submit">Approve</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No rentals awaiting approval.</p>
        <?php endif; ?>
    </div>
</body>
</html>