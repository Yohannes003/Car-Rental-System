<?php
include("includes/connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $car_id = intval($_POST['id']);
    $status = $_POST['status'];

    if (in_array($status, ['available', 'in_progress', 'rented'])) {
        $update_status = "UPDATE cars SET rental_status = ? WHERE id = ?";
        $stmt = $con->prepare($update_status);
        $stmt->bind_param("si", $status, $car_id);