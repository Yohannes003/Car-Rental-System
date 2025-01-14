<?php
session_start();

include("includes/connection.php");

class User {
    private $con;
    private $email;
    private $password;

    public function __construct($con) {
        $this->con = $con;
    }

    public function setData($email, $password) {
        $this->email = htmlentities(mysqli_real_escape_string($this->con, $email));
        $this->password = htmlentities(mysqli_real_escape_string($this->con, $password));
    }

    public function checkCredentials() {
        $query = "SELECT * FROM users WHERE email = '{$this->email}' AND password = '{$this->password}'";
        $result = mysqli_query($this->con, $query);
        return mysqli_num_rows($result) === 1;
    }

    public function login() {
        if ($this->checkCredentials()) {
            $_SESSION['email'] = $this->email;
            echo "<script>window.open('home.php', '_self');</script>";
        } else {
            echo "<script>alert('Your Email or Password is incorrect');</script>";
        }
    }
}

if (isset($_POST['login'])) {
    $user = new User($con);
    $user->setData($_POST['email'], $_POST['password']);
    $user->login();
}
?>
