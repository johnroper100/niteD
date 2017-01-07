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
if (isset($_POST['taskcreate'])) {
	$tname = mysqli_real_escape_string($con, $_POST['task-name']);
	$tdesc = mysqli_real_escape_string($con, htmlspecialchars($_POST['task-desc']));
	$timage = mysqli_real_escape_string($con, $_POST['task-image']);
    if($timage == "") {
        $newtimage = "no-media.jpg";
    } else {
        $newtimage = $timage;
    }
    
    $sql = "INSERT INTO tasks (task_name, task_desc, task_image) VALUES ('".$tname."', '".$tdesc."', '".$newtimage."')";

    if ($con->query($sql) === TRUE) {
        header("Location: tasks.php");
    } else {
        echo '<h3 style="text-align: center;">The task could not be created!</h3>';
        echo '<span style="text-align: center;">Error: ' . $sql . '<br>' . $con->error . '</span>';
    }
}
?>
<div class="row masonry-container">
    <div class="col-md-12">
        <div class="card">
            <div class="card-block">
                <h4 class="card-title">Add Task</h4>
                <div class="card-text">
                    <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="taskcreateform">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Task Name" id="task-name" name="task-name" required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" id="task-desc" name="task-desc" required rows="3" placeholder="Task Description"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="file" class="form-control" id="task-image" name="task-image">
                        </div>
                        <button class="btn btn-primary btn-lg btn-block" type="submit" name="taskcreate">Add Task</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
