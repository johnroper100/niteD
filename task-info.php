<?php
session_start();
if(isset($_SESSION['usr_id'])=="") {
	header("Location: login.php");
}

include_once 'dbconnect.php';
include 'header.php';

$taskID = $_GET["i"];

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

$result = mysqli_query($con, "SELECT * FROM tasks WHERE task_id = '" . $taskID. "'");
if ($row = mysqli_fetch_array($result)) {
?>
<div class="row">
    <div class="col-md-7">
        <div class="card">
            <img class="card-img-top img-fluid" width="100%" src="uploads/<?php echo $row['task_image'];?>" alt="<?php echo $row['task_name'];?>">
        </div>
    </div>
    <div class="col-md-5">
        <div class="card">
            <div class="card-block">
                <h4 class="card-title"><?php echo $row['task_name'];?></h4>
                <p class="card-text"><?php echo $row['task_desc'];?></p>
                <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="taskdeleteform">
                    <input type="hidden" name="tid" id="tid" value="<?php echo $taskID;?>">
                    <button class="btn btn-primary" type="submit" name="taskdelete">Delete Task</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php

} else {
    echo "<b>No task with that ID found!</b><br>So sorry for your loss.";
}

include 'footer.php';
?>
