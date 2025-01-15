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