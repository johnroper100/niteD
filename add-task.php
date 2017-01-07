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
    if(isset($_FILES['task_image'])) {
        if($_FILES['task_image']['name'] == "") {
            $newtimage = "no-media.jpg";
        } else {
            $newtimage = $_FILES['task_image']['name'];
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["task_image"]["name"]);
            $uploadOk = 1;
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            // Check if image file is a actual image or fake image
            $checkTImage = getimagesize($_FILES["task_image"]["tmp_name"]);
            if($checkTImage !== false) {
                $uploadOk = 1;
            } else {
                echo '<h3 style="text-align: center;">File is not an image.</h3>';
                $uploadOk = 0;
            }
            // Check if file already exists
            if (file_exists($target_file)) {
                echo '<h3 style="text-align: center;">Sorry, file already exists.</h3>';
                $uploadOk = 0;
            }
            // Check file size
            if ($_FILES["task_image"]["size"] > 5000000) {
                echo '<h3 style="text-align: center;">Sorry, your file is too large.</h3>';
                $uploadOk = 0;
            }
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "PNG" && $imageFileType != "JPG" && $imageFileType != "JPEG" && $imageFileType != "GIF" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                echo '<h3 style="text-align: center;">Sorry, only JPG, JPEG, PNG & GIF files are allowed.</h3>';
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk != 0) {
                if (!move_uploaded_file($_FILES["task_image"]["tmp_name"], $target_file)) {
                    echo '<h3 style="text-align: center;">Sorry, there was an error moving your file.</h3>';
                }
            }
        }
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
                    <form enctype="multipart/form-data" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="taskcreateform" >
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Task Name" id="task-name" name="task-name" required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" id="task-desc" name="task-desc" required rows="3" placeholder="Task Description"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="file" class="form-control" id="task_image" name="task_image">
                        </div>
                        <button class="btn btn-primary btn-lg btn-block" type="submit" name="taskcreate">Add Task</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
