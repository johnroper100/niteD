<?php
session_start();
if(isset($_SESSION['nited_usr_id'])=="") {
	header("Location: login.php");
}

if ($_SESSION['nited_usr_type']=="admin" || $_SESSION['nited_usr_type']=="mod") {
include_once 'dbconnect.php';
include 'header.php';

$userID = $_GET["i"];

if (isset($_POST['userdelete'])) {
    $uid = mysqli_real_escape_string($con, $_POST['uid']);

    $sql = "DELETE FROM users WHERE `id`=".$uid;

    if ($con->query($sql) === TRUE) {
        header("Location: users.php");
    } else {
        echo '<h3 style="text-align: center;">The user could not be deleted!</h3>';
        echo '<span style="text-align: center;">Error: ' . $sql . '<br>' . $con->error . '</span>';
    }
}

//set validation error flag as false
$error = false;

//check if form is submitted
if (isset($_POST['userupdate'])) {
    $uid2 = mysqli_real_escape_string($con, $_POST['uid2']);
    $name = mysqli_real_escape_string($con, $_POST['signup-name']);
    $email = mysqli_real_escape_string($con, $_POST['signup-email']);
    $password = mysqli_real_escape_string($con, $_POST['signup-pass']);
    $acc_type = mysqli_real_escape_string($con, $_POST['signup-account-type']);

    //name can contain only alpha characters and space
    if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
        $error = true;
        $name_error = "Name must contain only alphabets and space";
    }
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $email_error = "Please Enter Valid Email ID";
    }
    if (!$error) {
        if ($password == "") {
            $sql = "UPDATE users SET `name`='".$name."', `email`='".$email."', `account_type`='".$acc_type."' WHERE `id`='".$uid2."'";
        } else {
            $sql = "UPDATE users SET `name`='".$name."', `email`='".$email."', `password`='".md5($password)."', `account_type`='".$acc_type."' WHERE `id`=".$uid2;
        }
        if($con->query($sql) === TRUE) {
            $errormsg = $uid2;/*header("Location: user-info.php?i=".$uid2);*/
        } else {
            $errormsg = '<h3 style="text-align: center;">Error in editing user...Please try again later!</h3>';
        }
    }
}

$result = mysqli_query($con, "SELECT * FROM users WHERE `id` = '" . $userID. "'");
if ($row = mysqli_fetch_array($result)) {
    $email = $row['email'];
    // Removing Spaces
    $email = trim($email);
    // Make all Lower Case
    $email = strtolower($email);
    // Generating Hash
    $email_hash = md5($email);

    $path = "http://www.gravatar.com/avatar/".$email_hash;
?>
<div class="row">
    <div class="col-md-5">
        <div class="card">
            <img class="card-img-top img-fluid" width="100%" src="<?php echo $path?>/?d=mm&s=2048" alt="<?php echo $row['name']; ?>">
        </div>
    </div>
    <div class="col-md-7">
        <div class="card">
            <div class="card-block">
                <h4 class="card-title"><?php echo $row['name']; ?><span class="badge badge-default float-xs-right" style="font-size: 15px; margin-top: 5px;"><?php echo $row['account_type']; ?></span></h4>
                <a href="mailto:<?php echo $row['email']; ?>"><?php echo $row['email']; ?></a>
                <hr>
                <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="userdeleteform">
                    <input type="hidden" name="uid" id="uid" value="<?php echo $userID;?>">
                    <!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#userEditModal">
                        Edit User
                    </button>-->
                    <button class="btn btn-danger" type="submit" name="userdelete">Delete User</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="userEditModal" tabindex="-1" role="dialog" aria-labelledby="userEditModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
            </div>
            <div class="modal-body">
                <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="usereditform">
                    <div class="form-group">
                        <input type="text" class="form-control" value="<?php echo $row['name']; ?>" placeholder="Full Name" id="signup-name" name="signup-name" required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" value="<?php echo $row['email']; ?>" placeholder="Email" id="signup-email" name="signup-email" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Password" id="signup-pass" name="signup-pass">
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="signup-account-type" name="signup-account-type">
                            <option value="admin">Administrator</option>
                            <option value="mod">Moderator</option>
                            <option value="user">User</option>
                            <option value="rev">Reviewer</option>
                            <option value="guest">Guest</option>
                        </select>
                    </div>
                    <input type="hidden" name="uid2" id="uid2" value="<?php echo $userID;?>">
                    <button class="btn btn-danger" type="submit" name="userupdate">Update User</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php

} else {
    echo "<b>No user with that ID found!</b><br>So sorry for your loss.";
}

include 'footer.php'; }
?>
