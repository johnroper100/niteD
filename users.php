<?php
session_start();
if(isset($_SESSION['nited_usr_id'])=="") {
	header("Location: login.php");
}

if ($_SESSION['nited_usr_type']=="admin" || $_SESSION['nited_usr_type']=="mod") {
include_once 'dbconnect.php';
include 'header.php';

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
?>
<div class="row masonry-container">
<?php
$result = mysqli_query($con, "SELECT * FROM users");

while($row = mysqli_fetch_array($result)){ 
    $email = $row['email'];
    // Removing Spaces
    $email = trim($email);
    // Make all Lower Case
    $email = strtolower($email);
    // Generating Hash
    $email_hash = md5($email);

    $path = "http://www.gravatar.com/avatar/".$email_hash;
?>
    <div class="col-md-3 item">
        <div class="card">
            <img class="card-img-top img-fluid" width="100%" src="<?php echo $path?>/?d=mm&s=2048" alt="<?php echo $row['name']; ?>">
            <div class="card-block">
                <h4 class="card-title"><?php echo $row['name']; ?><span class="badge badge-default float-xs-right" style="font-size: 15px; margin-top: 5px;"><?php echo $row['account_type']; ?></span></h4>
                <p><a href="mailto:<?php echo $row['email']; ?>"><?php echo $row['email']; ?></a></p>
                <hr>
                <form role="form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" name="userdeleteform">
                    <a href="user-info.php?i=<?php echo $row['id']; ?>" class="btn btn-primary" style="margin-bottom: 5px;">View User</a>
                    <input type="hidden" name="uid" id="uid" value="<?php echo $row['id']; ?>">
                    <button class="btn btn-danger" type="submit" name="userdelete">Delete User</button>
                </form>
            </div>
        </div>
    </div>
<?php } ?>
</div>
<?php include 'footer.php'; } ?>
