<h2 style="text-align:center;">Change Your Password</h2>
<form action="" method="post">
	Enter Current Password<input type="password" name="current_pass" required>
	Enter New Password<input type="password" name="new_pass" required>
	Enter Reenter New Password<input type="password" name="new_pass_again" required>
	<input type="submit" name="change_pass" value="Change Password" />
</form>
<?php
include("includes/db.php");
if(isset($_POST['change_pass'])){
	$current_pass = $_POST['current_pass'];
	$new_pass = $_POST['new_pass'];
	$new_again = $_POST['new_pass_again'];
	$sel_pass = "select * from customers where customer_pass='$current_pass' AND customer_email='$user' ";
	$run_pass = mysqli_query($con, $sel_pas);
	$check_pass = mysqli_num_rows($run_pass);
	if(check_pass==0){
		echo "<script>alert('Your current password is wrong!')</script>";
		exit();
	}
	if($new_pass!=$new_again){
		echo "<script>alert('New Password do not match!')</script>";
		exit();
	}
	else{
		$update_pass="update customers set customer_pass='$new_pass' where customer_email='$user'";
		$run_update = mysqli_query($con, $update_pass);
		echo "<script>alert('Your password was updated succesfully!')</script>";
		echo "<script>window.open('my_account.php','_self')</script>";
	}
	
}
?>