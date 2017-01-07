<?php
session_start();
if(isset($_SESSION['usr_id'])=="") {
	header("Location: login.php");
}

include_once 'dbconnect.php';
include 'header.php';

//set validation error flag as false
$error = false;

//check if form is submitted
if (isset($_POST['signup'])) {
	$name = mysqli_real_escape_string($con, $_POST['signup-name']);
	$email = mysqli_real_escape_string($con, $_POST['signup-email']);
	$password = mysqli_real_escape_string($con, $_POST['signup-pass']);
	$cpassword = mysqli_real_escape_string($con, $_POST['signup-pass-conf']);
	
	//name can contain only alpha characters and space
	if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
		$error = true;
		$name_error = "Name must contain only alphabets and space";
	}
	if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
		$error = true;
		$email_error = "Please Enter Valid Email ID";
	}
	if($password != $cpassword) {
		$error = true;
		$cpassword_error = "Password and Confirm Password doesn't match";
	}
	if (!$error) {
		if(mysqli_query($con, "INSERT INTO users(name,email,password) VALUES('" . $name . "', '" . $email . "', '" . md5($password) . "')")) {
			header("Location: tasks.php");
		} else {
			$errormsg = '<h3 style="text-align: center;">Error in registering...Please try again later!</h3>';
		}
	}
}
?>
<?php if (isset($errormsg)) { echo $errormsg; } ?>
<div class="row masonry-container">
    <div class="col-md-12">
        <div class="card">
            <div class="card-block">
                <h4 class="card-title">Add User</h4>
                <div class="card-text">
                    <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="signupform">
                        <div class="form-group">
                            <input type="text" class="form-control" value="<?php if($error) echo $name; ?>" placeholder="Full Name" id="signup-name" name="signup-name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" value="<?php if($error) echo $email; ?>" placeholder="Email" id="signup-email" name="signup-email" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Password" id="signup-pass" name="signup-pass" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" value="" placeholder="Confirm Password" id="signup-pass-conf" name="signup-pass-conf" required>
                        </div>
                        <button class="btn btn-primary btn-lg btn-block" type="submit" name="signup">Add User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
