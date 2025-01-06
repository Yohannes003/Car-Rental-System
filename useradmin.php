<?php
include("includes/connection.php");

class Database {
    private $con;

    public function __construct($connection) {
        $this->con = $connection;
    }

    public function prepare($query) {
        return $this->con->prepare($query);
    }

    public function query($query) {
        return mysqli_query($this->con, $query);
    }
}

class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function deleteUser($user_id) {
        $delete_query = "DELETE FROM users WHERE id = ?";
        $stmt = $this->db->prepare($delete_query);
        $stmt->bind_param("i", $user_id);
        return $stmt->execute();
    }

    public function editUser($user_id, $first_name, $last_name, $email, $user_image) {
        $update_query = "UPDATE users SET first_name = ?, last_name = ?, email = ?, user_image = ? WHERE id = ?";
        $stmt = $this->db->prepare($update_query);
        $stmt->bind_param("ssssi", $first_name, $last_name, $email, $user_image, $user_id);
        return $stmt->execute();
    }

    public function getUserById($user_id) {
        $query = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getAllUsers() {
        $query = "SELECT * FROM users";
        return $this->db->query($query);
    }
}
$db = new Database($con);
$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['operation'])) {
        $user_id = intval($_POST['user_id']);

        if ($_POST['operation'] == 'delete') {
            if ($user->deleteUser($user_id)) {
                echo "<script>alert('User deleted successfully!'); window.location.href = 'useradmin.php';</script>";
            } else {
                echo "<script>alert('Failed to delete user.');</script>";
            }
        }

        if ($_POST['operation'] == 'edit') {
            $first_name = htmlspecialchars($_POST['first_name']);
            $last_name = htmlspecialchars($_POST['last_name']);
            $email = htmlspecialchars($_POST['email']);
            
            $user_image = $_FILES['user_image']['name'];
            if ($user_image) {
                $target_dir = "img/";
                $target_file = $target_dir . basename($user_image);
                move_uploaded_file($_FILES['user_image']['tmp_name'], $target_file);
            } else {
                $user_data = $user->getUserById($user_id);
                $user_image = $user_data['user_image'];
            }

            if ($user->editUser($user_id, $first_name, $last_name, $email, $user_image)) {
                echo "<script>alert('User updated successfully!'); window.location.href = 'useradmin.php';</script>";
            } else {
                echo "<script>alert('Failed to update user.');</script>";
            }
        }
    }
}

$users_result = $user->getAllUsers();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Users</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        button {
            background: #007bff;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }
        button:hover {
            background: #0056b3;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .action-buttons button {
            background: #28a745;
        }
        .action-buttons button:hover {
            background: #218838;
        }
        .delete-button {
            background: #dc3545;
        }
        .delete-button:hover {
            background: #c82333;
        }
        img.user-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
        }

        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            max-width: 500px;
            width: 100%;
        }
        .modal-header {
            font-size: 1.5rem;
            margin-bottom: 15px;
        }
        .modal-body {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .modal-footer {
            text-align: right;
            margin-top: 20px;
        }
        .modal-footer button {
            background: #007bff;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .modal-footer button:hover {
            background: #0056b3;
        }
        .close-modal {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            color: #888;
            cursor: pointer;
        }
        .close-modal:hover {
            color: #000;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin - Manage Users</h1>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Image</th>
                    <th>Registration Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = mysqli_fetch_assoc($users_result)): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= htmlspecialchars($user['first_name']) . ' ' . htmlspecialchars($user['last_name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td>
                            <?php if ($user['user_image']): ?>
                                <img src="img/<?= $user['user_image'] ?>" alt="User Image" class="user-image">
                            <?php else: ?>
                                No Image
                            <?php endif; ?>
                        </td>
                        <td><?= date("Y-m-d", strtotime($user['user_reg_date'])) ?></td>
                        <td class="action-buttons">
                            <button onclick="openModal(<?= $user['id'] ?>)">Edit</button>

                            <form action="useradmin.php" method="POST" style="display:inline;">
                                <input type="hidden" name="operation" value="delete">
                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                <button type="submit" class="delete-button" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <div id="edit-modal-<?= $user['id'] ?>" class="modal">
                        <span class="close-modal" onclick="closeModal(<?= $user['id'] ?>)">&times;</span>
                        <h2 class="modal-header">Edit User</h2>
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="operation" value="edit">
                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                            
                            <label for="first_name">First Name:</label>
                            <input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required><br><br>
                            
                            <label for="last_name">Last Name:</label>
                            <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required><br><br>

                            <label for="email">Email:</label>
                            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required><br><br>

                            <label for="user_image">User Image:</label>
                            <input type="file" name="user_image"><br><br>

                            <div class="modal-footer">
                                <button type="submit">Update</button>
                                <button type="button" onclick="closeModal(<?= $user['id'] ?>)">Cancel</button>
                            </div>
                        </form>
                    </div>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        function openModal(userId) {
            document.getElementById('edit-modal-' + userId).style.display = 'block';
        }

        function closeModal(userId) {
            document.getElementById('edit-modal-' + userId).style.display = 'none';
        }
    </script>
</body>
</html>
