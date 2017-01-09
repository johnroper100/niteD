<?php
session_start();
if(isset($_SESSION['nited_usr_id'])=="") {
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
    $tstate = mysqli_real_escape_string($con, $_POST['task_state']);
    $ttype = mysqli_real_escape_string($con, $_POST['task_media_type']);
    if(isset($_FILES['task_media'])) {
        if($_FILES['task_media']['name'] == "") {
            $newtimage = "no-media.jpg";
        } else {
            $newtimage = $_FILES['task_media']['name'];
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["task_media"]["name"]);
            $uploadOk = 1;
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            // Check if file already exists
            if (file_exists($target_file)) {
                echo '<h3 style="text-align: center;">Sorry, file already exists.</h3>';
                $uploadOk = 0;
            }
            // Check file size
            if ($_FILES["task_media"]["size"] > 50000000) {
                echo '<h3 style="text-align: center;">Sorry, your file is too large.</h3>';
                $uploadOk = 0;
            }
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "PNG" && $imageFileType != "JPG" && $imageFileType != "JPEG" && $imageFileType != "GIF" && $imageFileType != "jpeg"
            && $imageFileType != "gif" && $imageFileType != "mp4" && $imageFileType != "MP4") {
                echo '<h3 style="text-align: center;">Sorry, only JPG, JPEG, PNG, GIF & MP4 files are allowed.</h3>';
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk != 0) {
                if (!move_uploaded_file($_FILES["task_media"]["tmp_name"], $target_file)) {
                    echo '<h3 style="text-align: center;">Sorry, there was an error moving your file.</h3>';
                }
            }
        }
    }
    $sql = "INSERT INTO tasks (task_name, task_desc, task_state, task_media_type, task_media) VALUES ('".$tname."', '".$tdesc."', '".$tstate."', '".$ttype."', '".$newtimage."')";
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
                    <form enctype="multipart/form-data" role="form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" name="taskcreateform" >
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Task Name" id="task-name" name="task-name" required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" id="task-desc" name="task-desc" required rows="3" placeholder="Task Description"></textarea>
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="task_media_type" name="task_media_type">
                                <option value="img">Image</option>
                                <option value="vid">Video</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="file" class="form-control" id="task_media" name="task_media">
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="task_state" name="task_state">
                                <option value="Final">Final</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Missing File">Missing File</option>
                                <option value="Not Active">Not Active</option>
                                <option value="Not Assigned">Not Assigned</option>
                                <option value="On Hold">On Hold</option>
                                <option value="Redo">Redo</option>
                            </select>
                        </div>
                        <button class="btn btn-primary btn-lg btn-block" type="submit" name="taskcreate">Add Task</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
