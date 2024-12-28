<?php
include("includes/connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['operation'])) {
    if ($_POST['operation'] === 'add_or_edit') {

        $car_year = intval($_POST['car_year']);
        $car_name = htmlspecialchars($_POST['car_name']);
        $price_per_day = floatval($_POST['price_per_day']);
        $car_image = $_FILES['car_image']['name'];
        $target_dir = "img/";
        $target_file = $target_dir . basename($car_image);
        $is_edit = isset($_POST['id']);

      