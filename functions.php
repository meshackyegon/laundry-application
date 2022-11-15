<?php 
include ("qrcode/qrlib.php");
session_start();

// connect to database
$db = mysqli_connect('localhost', 'root', '', 'multi_login');

// variable declaration
$username = "";
$email    = "";
$id = 0;
$update = false;
$errors   = array(); 

// call the register() function if register_btn is clicked
if (isset($_POST['register_btn'])) {
	register();
}

// REGISTER USER
function register(){
	// call these variables with the global keyword to make them available in function
	global $db, $errors, $username, $email, $location , $phoneNo;

	// receive all input values from the form. Call the e() function
    // defined below to escape form values
	$username    =  e($_POST['username']);
	$email       =  e($_POST['email']);
	$location       =  e($_POST['location']);
	$phoneNo       =  e($_POST['phoneNo']);
	$password_1  =  e($_POST['password_1']);
	$password_2  =  e($_POST['password_2']);

	// form validation: ensure that the form is correctly filled
	if (empty($username)) { 
		array_push($errors, "Username is required"); 
	}
	if (empty($email)) { 
		array_push($errors, "Email is required");
	 }
	if (empty($location)) { 
			array_push($errors, "Location is required"); 
	}
	if (empty($phoneNo)) { 
		array_push($errors, "Phone number is required");
	 }
	if (empty($password_1)) { 
		array_push($errors, "Password is required"); 
	}
	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
	}

	// register user if there are no errors in the form
	if (count($errors) == 0) {
		$password = md5($password_1);//encrypt the password before saving in the database

		if (isset($_POST['user_type'])) {
			$user_type = e($_POST['user_type']);
			$query = "INSERT INTO users (username, email, location, phoneNo, user_type, password) 
					  VALUES('$username', '$email', '$location', '$phoneNo', '$user_type', '$password')";
			mysqli_query($db, $query);
			$_SESSION['success']  = "New user successfully created!!";
			header('location: home.php');
		}else{
			$query = "INSERT INTO users (username, email, location, phoneNo, user_type, password) 
					  VALUES('$username', '$email','$location', '$phoneNo ','user', '$password')";
			mysqli_query($db, $query);

			// get id of the created user
			$logged_in_user_id = mysqli_insert_id($db);

			$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
			$_SESSION['success']  = "You are now logged in";
			header('location: index.php');				
		}
	}
}

// return user array from their id
function getUserById($id){
	global $db;
	$query = "SELECT * FROM users WHERE id=" . $id;
	$result = mysqli_query($db, $query);

	$user = mysqli_fetch_assoc($result);
	return $user;
}

// escape string
function e($val){
	global $db;
	return mysqli_real_escape_string($db, trim($val));
}

function display_error() {
	global $errors;

	if (count($errors) > 0){
		echo '<div class="error">';
			foreach ($errors as $error){
				echo $error .'<br>';
			}
		echo '</div>';
	}
}
function isLoggedIn()
{
	if (isset($_SESSION['user'])) {
		return true;
	}else{
		return false;
	}
}

// <?php
// include('functions.php');
// if (!isLoggedIn()) {
// 	$_SESSION['msg'] = "You must log in first";
// 	header('location: login.php');
// }

// //...
// 

// log user out if logout button clicked
if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: login.php");
}

// call the login() function if register_btn is clicked
if (isset($_POST['login_btn'])) {
	login();
}

// LOGIN USER
function login(){
	global $db, $username, $errors;

	// grap form values
	$username = e($_POST['username']);
	$password = e($_POST['password']);

	// make sure form is filled properly
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}

	// attempt login if no errors on form
	if (count($errors) == 0) {
		$password = md5($password);

		$query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
		$results = mysqli_query($db, $query);

		if (mysqli_num_rows($results) == 1) { // user found
			// check if user is admin or user
			$logged_in_user = mysqli_fetch_assoc($results);
			if ($logged_in_user['user_type'] == 'admin') {

				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in";
				header('location: admin/home.php');		  
			}else{
				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in";

				header('location: laundrywash.php');
			}
		}else {
			array_push($errors, "Wrong username/password combination");
		}
	}
}

// ...
function isAdmin()
{
	if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin' ) {
		return true;
	}else{
		return false;
	}
}

// if(isset($_POST['upload'])){
if(isset($_REQUEST['upload'])){
	laundry();
}


function laundry()
{
	global $sdate, $pdate, $db, $errors, $filename, $typelaundry;

	$sdate = e($_POST['sdate']);
	$laundrytype = e($_POST['ltype']);
	$filename=e($_POST["uploadfile"] = !'');
	$pdate = e($_POST['pdate']);

	// make sure form is filled properly with the right details
	if (empty($sdate)) {
		array_push($errors, "Submission date is required");
	}
	if (empty($laundrytype)) {
		array_push($errors, "Type of clothes to be washed is required");
	}
	if (empty($filename)) {
		array_push($errors, "File upload is required");
	}
	if (empty($pdate)) {
		array_push($errors, "Possible pick up date is required");
	}
	if(count($errors)==0){
		$filename = $_FILES["uploadfile"]["name"];
		// $tempname = $_FILES["uploadfile"]["tmp_name"] =!'';
		$target = "image/".basename($filename);
		// $folder = "./image/" . $filename;
    	if($filename){
			// insert the values to database
			$sql = "INSERT INTO laundry (sdate,laundrytype,filename,pdate) VALUES ('$sdate','$laundrytype','$filename','$pdate')";
			$result = mysqli_query($db, $sql);
			//moving the image to image folder
			if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $target)) {
				echo "<h2>  Image uploaded successfully!</h2>";
				header('location: payment.php');
			} else {
			echo "<h2>  Failed to upload image!</h2>";
			header('location: laundrywash.php');}
		}else{
			echo"<h2>file type not supported!<h2>";
			header('location: laundrywash.php');
	}
	}
}

if (isset($_POST['update'])) {
	$id = $_POST['id'];
	$username = $_POST['username'];
	$email = $_POST['email'];
	$location = $_POST['location'];
	$phoneNo = $_POST['phoneNo'];
	$password = $_POST['password'];

	mysqli_query($db, "UPDATE users SET username='$username', email='$email', location='$location', phoneNo='$phoneNo',password='$password' 
	WHERE id=$id");
	$_SESSION['message'] = "Details updated!"; 
	header('location: laundrywash.php');
}


if (isset($_GET['del'])) {
	$id = $_GET['del'];
	mysqli_query($db, "DELETE FROM users WHERE id=$id");
	$_SESSION['message'] = "User deleted"; 
	header('location: register.php');
}




if(isset($_POST['submit'])){
	action();
}
function action(){
	
		$t=mysqli_query($db, "SELECT *FROM laundry WHERE pdate='$pdate'; ");
		$date=date_create(date("y-m-d"));
		echo $date;

		while($row=mysqli_fetch_assoc($t)){
			   $date2=date_create($row['pdate']);
			   $diff=date_diff($date,$date2);
			   $day=$diff->format("%a");  
			   if($day){
				$name_m= $row['username'];
				$sdate=$row['sdate']; 
				$sql_m=mysqli_query($db, "SELECT * FROM laundry WHERE username='$row[username]' ;");

				$t2=mysqli_fetch_assoc($sql_m); 
				$subject="Clothes pick up date";
				$msg="Hello! 
				This is sent to notify you that the clothes are ready to be picked(Id: ".$sdate.") in the next two days";
				$from="from: henry@gmail.com";
				if(mail($t2['email'],$subject, $msg, $from  )){
				?>
				<script> 
					alert("mail has been sent successfully");
				</script>
			   <?php 
			   }else{
				?>
				<script> 
					alert("mail not sent");
				</script>
			   <?php    
				}

			   }
		}
} 
