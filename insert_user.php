<?php
include("includes/connection.php");

class Userc {
    private $con;
    private $first_name;
    private $last_name;
    private $email;
    private $password;
    private $profile_pic;

    public function __construct($con, $first_name, $last_name, $email, $password) {
        $this->con = $con;
        $this->first_name = htmlentities(mysqli_real_escape_string($this->con, $first_name));
        $this->last_name = htmlentities(mysqli_real_escape_string($this->con, $last_name));
        $this->email = htmlentities(mysqli_real_escape_string($this->con, $email));
        $this->password = htmlentities(mysqli_real_escape_string($this->con, $password));
    }

    public function validatePassword() {
        if (strlen($this->password) < 9) {
            echo "<script>alert('Password should be minimum 9 characters!')</script>";
            exit();
        }
    }

    public function checkEmailExistence() {
        $check_email = "SELECT * FROM users WHERE email='$this->email'";
        $run_email = mysqli_query($this->con, $check_email);
        $check = mysqli_num_rows($run_email);
        
        if ($check == 1) {
            echo "<script>alert('Email already exist, Please try using another email')</script>";
            echo "<script>window.open('accounts.php', '_self')</script>";
            exit();
        }
    }

    public function setProfilePicture() {
        $rand = rand(1, 3);
        if ($rand == 1) {
            $this->profile_pic = "head_red.png";
        } else if ($rand == 2) {
            $this->profile_pic = "head_sun_flower.png";
        } else if ($rand == 3) {
            $this->profile_pic = "head_turqoise.png";
        }
    }

    public function registerUser() {
        $insert = "INSERT INTO users (first_name, last_name, email, password, user_image, user_reg_date)
            VALUES('$this->first_name', '$this->last_name', '$this->email', '$this->password', '$this->profile_pic', NOW())";
        
        $query = mysqli_query($this->con, $insert);

        if ($query) {
            echo "<script>alert('Well Done $this->first_name, you are good to go.')</script>";
            echo "<script>window.open('home.php', '_self')</script>";
        } else {
            echo "<script>alert('Registration failed, please try again!')</script>";
            echo "<script>window.open('accounts.php', '_self')</script>";
        }
    }
}

if (isset($_POST['sign_up'])) {
    $user = new Userc($con, $_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['password']);
    $user->validatePassword();
    $user->checkEmailExistence();
    $user->setProfilePicture();
    $user->registerUser();
}
?>
