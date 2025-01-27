<?php
session_start();

include("includes/connection.php"); 

if (!isset($_SESSION['email'])) {
    header("Location: accounts.php");
    exit();
}

$user = $_SESSION['email'];
$get_user = "SELECT * FROM users WHERE email='$user'"; 
$run_user = mysqli_query($con, $get_user);

if (!$run_user || mysqli_num_rows($run_user) == 0) {
    echo "User not found.";
    exit();
}

$row = mysqli_fetch_array($run_user);
$id = $row['id'];
$first_name = $row['first_name'];
$last_name = $row['last_name'];
$email = $row['email'];
$password = $row['password'];
$user_image = $row['user_image'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = mysqli_real_escape_string($con, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($con, $_POST['last_name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $image_name = $user_image;

    if (isset($_FILES['user_image']) && $_FILES['user_image']['error'] === UPLOAD_ERR_OK) {
        $image_tmp = $_FILES['user_image']['tmp_name'];
        $image_name = time() . '_' . $_FILES['user_image']['name'];
        move_uploaded_file($image_tmp, "users/$image_name"); 
    }

    $update_query = "UPDATE users 
                     SET first_name = '$first_name', last_name = '$last_name', email = '$email', password = '$password', user_image = '$image_name' 
                     WHERE id = '$id'";

    if (mysqli_query($con, $update_query)) {
        $_SESSION['success'] = "Profile updated successfully!";
        header("Location: home.php");
        exit();
    } else {
        $_SESSION['error'] = "Error updating profile.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<style>
    .profile {
    width: 50%;
    margin: 20px auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    text-align: center;
}

.profile-heading h1 {
    margin-bottom: 20px;
}

.profile-image img {
    border-radius: 50%;
    margin-bottom: 15px;
}

.profile-form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.profile-form label {
    margin: 10px 0 5px;
    font-weight: bold;
}

.profile-form input {
    width: 100%;
    max-width: 300px;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.btn {
    padding: 10px 20px;
    background-color: #4CAF50;
    color: #fff;
    border: none;
    cursor: pointer;
    border-radius: 5px;
}

.btn:hover {
    background-color: #45a049;
}

.success {
    color: green;
    margin-bottom: 20px;
}

.error {
    color: red;
    margin-bottom: 20px;
}

</style>
<body>

<section class="profile">
    <div class="profile-heading">
        <h1>Your Profile</h1>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form action="profile.php" method="POST" enctype="multipart/form-data" class="profile-form">
        <div class="profile-image">
            <img src="users/<?php echo htmlspecialchars($user_image); ?>" alt="Profile Image" width="100" height="100">
        </div>
        <label for="user_image">Update Profile Picture</label>
        <input type="file" id="user_image" name="user_image" accept="images/*">

        <label for="first_name">First Name</label>
        <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>" required>

        <label for="last_name">Last Name</label>
        <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($password); ?>" required>

        <button type="submit" class="btn">Update Profile</button>
    </form>
</section>

</body>
</html>
