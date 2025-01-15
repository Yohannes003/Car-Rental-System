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