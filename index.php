<?php session_start(); ?>	

<?php include('./config/db_connection.php');?>

<?php 

	$notif = '';

	if (isset($_POST['signin'])) {
		
		// $fname = $_POST['fname'];
		// $lname = $_POST['lname'];
		$username = $_POST['username'];
		$password = $_POST['password'];

		$sql = "SELECT * FROM user WHERE user_name = '$username' && password = '$password'";
		$result = mysqli_query($conn, $sql);
		$num = mysqli_num_rows($result);

		if ($num == 1) {		
			$_SESSION['username'] = $_POST['username'];
			$_SESSION['login'] ="You are now login!";
			// echo $_SESSION['username'];
			header('Location: ./home.php');

		}

		else{
			
			$notif = "unmatched username & password";
			// header('Location: ./index.php');
			// echo "<script> alert('unmatched username & password');</script>";
		}

	}
?>


<!DOCTYPE html>
<html lang="en">

<?php include('./template/log_header.php'); ?>
<div id="backtotop"></div>


<!-- this is for alert message -->

<?php  if (isset($_SESSION['registered'])) {  ?>

	<div class="alert alert-primary alert-dismissible fade show" role="alert">
	  <strong><?php echo $_SESSION['registered'] ?></strong> You can now sign in.
	  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>

	<?php unset($_SESSION['registered']); ?>
<?php } ?>

<!-- ///////////////////////// -->

<div class="modal-dialog modal-login">
	<div class="modal-content">
		<div class="modal-header">				
			<h4 class="modal-title">Sign in</h4>
		</div>
		<div class="modal-body">			
			<form action=" <?php echo $_SERVER['PHP_SELF']; ?> " method="post">
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
					<button type="submit" name="signin" class="btn btn-primary btn-block btn-lg">Login</button>
				</div>
				<p class="text-danger"> <?php echo $notif; ?>  </p>
			</form>
		</div>
		<div class="modal-footer">Don't have an account? <a href="./register.php">Create one</a></div>
		</div>
	</div>
</div>


</html>