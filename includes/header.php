<?php
include("includes/connection.php");
?>    	
<?php 
	$user = $_SESSION['email'];
	$get_user = "select * from users where email='$user'"; 
	$run_user = mysqli_query($con,$get_user);
	$row=mysqli_fetch_array($run_user);
			
	$id = $row['id']; 
	$first_name = $row['first_name'];
	$last_name = $row['last_name'];
	$email = $row['email'];
	$password = $row['password'];
	$user_image = $row['user_image'];
	$register_date = $row['user_reg_date'];
?>