<?php
session_start();

if(isset($_SESSION['nited_usr_id'])!="") {
	header("Location: tasks.php");
}

include_once 'dbconnect.php';
include 'header.php';

//check if form is submitted
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($con, $_POST['login-email']);
    $password = mysqli_real_escape_string($con, $_POST['login-pass']);
    $result = mysqli_query($con, "SELECT * FROM users WHERE email = '" . $email. "' and password = '" . md5($password) . "'");

    if ($row = mysqli_fetch_array($result)) {
        $_SESSION['nited_usr_id'] = $row['id'];
        $_SESSION['nited_usr_name'] = $row['name'];
        $_SESSION['nited_usr_email'] = $row['email'];
        $_SESSION['nited_usr_type'] = $row['account_type'];
        header("Location: tasks.php");
    } else {
        $errormsg = '<h3 style="text-align: center;">Incorrect Email or Password!</h3>';
    }
}
?>
<?php if (isset($errormsg)) { echo $errormsg; } ?>
<div class="row masonry-container">
    <div class="col-md-12">
        <div class="card">
            <div class="card-block">
                <h4 class="card-title">Login</h4>
                <div class="card-text">
                    <form role="form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" name="loginform">
                        <div class="form-group">
                            <input type="email" class="form-control" value="<?= $_GET['e'] ?>" placeholder="Email" id="login-email" name="login-email" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Password" id="login-pass" name="login-pass" required>
                        </div>
                        <button class="btn btn-primary btn-lg btn-block" type="submit" name="login">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
