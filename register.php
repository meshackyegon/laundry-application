<?php include('functions.php') ?>

<?php 
	if (isset($_GET['edit'])) {
		$id = $_GET['edit'];
		$update = true;
		$record = mysqli_query($db, "SELECT * FROM users WHERE id=$id");
		if (mysqli_num_rows($record) == 1 ) {
			$n = mysqli_fetch_array($record);
			$name = $n['username'];
			$address = $n['email'];
			$address = $n['location'];
			$address = $n['phoneNo'];
			$address = $n['password'];
		}
	}
?>



<!DOCTYPE html>
<html>
<head>
	<title>Registration in Laundry System </title>
	<link rel="stylesheet" href="register.css">
</head>
<body>
<div class="header">
	<h2>Register</h2>
</div>
<form method="post" action="register.php">
    <?php echo display_error(); ?>
	<input type="hidden" name="id" value="<?php echo $id; ?>">
	<div class="input-group">
		<label>Username</label>
		<input type="text" name="username" value="<?php echo $username; ?>">
	</div>
	<div class="input-group">
		<label>Email</label>
		<input type="email" name="email" value="<?php echo $email; ?>">
	</div>
	<div class="input-group">
		<label>Location</label>
		<input type="text" name="location" >  
	</div>
	<div class="input-group">
		<label>Phone Number</label>
		<input type="text" name="phoneNo">
	</div>
	<div class="input-group">
		<label>Password</label>
		<input type="password" name="password_1">
	</div>
	<div class="input-group">
		<label>Confirm password</label>
		<input type="password" name="password_2">
	</div>
	<div class="input-group">
		<!-- <button type="submit" class="btn" name="register_btn">Register</button> -->
		<?php if ($update == true): ?>
		<button class="btn" type="submit" name="update" style="background: #556B2F;" >update</button>
		<?php else: ?>
			<button class="btn" type="submit" name="register_btn" >Save</button>
		<?php endif ?>
	</div>
	<p>
		Already a member? <a href="login.php">Sign in</a>
	</p>
</form>
</body>
</html>