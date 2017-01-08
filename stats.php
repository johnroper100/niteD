<?php
session_start();
if(isset($_SESSION['usr_id'])=="") {
	header("Location: login.php");
}

include_once 'dbconnect.php';
include 'header.php';

$result1 = mysqli_query($con, "SELECT * FROM tasks");
$num_rows1 = mysqli_num_rows($result1);
$result15 = mysqli_query($con, "SELECT * FROM tasks WHERE task_state='Final'");
$num_rows15 = mysqli_num_rows($result15);
$num_rows1_perc = $num_rows15/$num_rows1*100;
$result2 = mysqli_query($con, "SELECT * FROM users");
$num_rows2 = mysqli_num_rows($result2);
$result3 = mysqli_query($con, "SELECT * FROM comments");
$num_rows3 = mysqli_num_rows($result3);

?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-block">
                <h4 class="card-title">Project Stats</h4>
                <hr>
                <p class="card-text"><b>Amount Done:</b></p>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: <?php echo $num_rows1_perc;?>%" aria-valuenow="<?php echo $num_rows1_perc;?>" aria-valuemin="0" aria-valuemax="100"><?php echo $num_rows1_perc;?>%</div>
                </div>
                <p class="card-text"><b>Number of Tasks:</b> <?php echo $num_rows1;?></p>
                <p class="card-text"><b>Number of Users:</b> <?php echo $num_rows2;?></p>
                <p class="card-text"><b>Number of Coments:</b> <?php echo $num_rows3;?></p>
            </div>
        </div>
    </div>
</div>
<?php
include 'footer.php';
?>
