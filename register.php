<?php session_start(); ?>

<?php include('./config/db_connection.php');?>

<?php 

	$notif = '';

	if (isset($_POST['register'])) {
		
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$retype = $_POST['retype_password'];

		$sql = "SELECT * FROM user WHERE user_name = '$username'";
		$result = mysqli_query($conn, $sql);
		$num = mysqli_num_rows($result);

		if ($num == 1) {
			$notif = "This username is already exist";
		}

		elseif ($password !== $retype) {
			$notif = "unmatched password";
		}

		else{

			$sqel = "INSERT INTO user(first_name, last_name, user_name, password) VALUES('$fname', '$lname', '$username', '$password')";
			$results = mysqli_query($conn, $sqel);
			$_SESSION['registered'] = "You are registered!";
			header('Location: ./index.php');

		}

	}
?>


<!DOCTYPE html>
<html lang="en">

<?php include('./template/log_header.php'); ?>
<div id="backtotop"></div>

<div class="modal-dialog modal-login">
	<div class="modal-content">
		<div class="modal-header">				
			<h4 class="modal-title">Register</h4>
		</div>
		<div class="modal-body">			
			<form action=" <?php echo $_SERVER['PHP_SELF']; ?> " method="post">
				
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
						<input type="text" class="form-control" name="fname" placeholder="First Name" required="required">
					</div>
				</div>

				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
						<input type="text" class="form-control" name="lname" placeholder="Last Name" required="required">
					</div>
				</div>

				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
						<input type="text" class="form-control" name="username" placeholder="Username" required="required">
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-lock"></i></span>
						<input type="password" class="form-control" name="password" placeholder="Password" required="required">
					</div>
				</div>

				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-lock"></i></span>
						<input type="password" class="form-control" name="retype_password" placeholder="Re-type Password" required="required">
					</div>
				</div>

				<div class="form-group">
					<button type="submit" name="register" class="btn btn-primary btn-block btn-lg">Register</button>
				</div>
				<p class="text-danger"> <?php echo $notif; ?>  </p>
			</form>
		</div>
		<div class="modal-footer">Do you have an account? <a href="./index.php">Sign in</a></div>
	</div>
</div>  

</html>