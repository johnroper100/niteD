<?php
session_start();
if(isset($_SESSION['usr_id'])=="") {
	header("Location: login.php");
}

include_once 'dbconnect.php';
include 'header.php';

if (isset($_POST['taskdelete'])) {
    $tid = mysqli_real_escape_string($con, $_POST['tid']);

    $sql = "DELETE FROM tasks WHERE task_id=".$tid;

    if ($con->query($sql) === TRUE) {
        header("Location: tasks.php");
    } else {
        echo '<h3 style="text-align: center;">The task could not be deleted!</h3>';
        echo '<span style="text-align: center;">Error: ' . $sql . '<br>' . $con->error . '</span>';
    }
}
?>
<div class="row masonry-container">
<?php
$result = mysqli_query($con, "SELECT * FROM tasks");

while($row = mysqli_fetch_array($result)){ ?>
    <div class="col-md-4 item">
        <div class="card" >
            <img class="card-img-top img-fluid" width="100%" src="uploads/<?php echo $row['task_image']; ?>" onError="this.onerror=null;this.src='uploads/no-media.jpg';" alt="<?php echo $row['task_name']; ?>">
            <div class="card-block">
                <h4 class="card-title"><?php echo $row['task_name']; ?></h4>
                <p class="card-text"><?php echo $row['task_desc']; ?></p>
                <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="taskdeleteform">
                    <input type="hidden" name="tid" id="tid" value="<?php echo $row['task_id']; ?>">
                    <a href="task-info.php?i=<?php echo $row['task_id']; ?>" class="btn btn-primary">View Task</a>
                    <button class="btn btn-danger" type="submit" name="taskdelete">Close Task</button>
                </form>
            </div>
        </div>
    </div>
<?php } ?>
</div>
<?php include 'footer.php'; ?>
