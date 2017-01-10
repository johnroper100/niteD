<?php
session_start();
if(isset($_SESSION['nited_usr_id'])=="") {
	header("Location: login.php");
}

include_once 'dbconnect.php';
include 'header.php';

$taskID = $_GET["i"];

if (isset($_POST['taskdelete'])) {
    $tid = mysqli_real_escape_string($con, $_POST['tid']);

    $sql = "DELETE FROM tasks WHERE task_id=".$tid;
    $sql2 = "DELETE FROM comments WHERE task_id=".$tid;

    if ($con->query($sql) === TRUE && $con->query($sql2) === TRUE) {
        header("Location: tasks.php");
    } else {
        echo '<h3 style="text-align: center;">The task could not be deleted!</h3>';
        echo '<span style="text-align: center;">Error: ' . $sql . '<br>' . $con->error . '</span>';
    }
}

if (isset($_POST['taskcomment'])) {
    $tid = mysqli_real_escape_string($con, $_POST['tid']);
    $cname = $_SESSION['nited_usr_name'];
	$cdesc = mysqli_real_escape_string($con, htmlspecialchars($_POST['comment_item']));

    $sql = "INSERT INTO comments (user_name, comment_text, task_id) VALUES ('".$cname."', '".$cdesc."', '".$tid."')";

    if ($con->query($sql) === TRUE) {
        header("Location: task-info.php?i=".$tid);
    } else {
        echo '<h3 style="text-align: center;">The comment could not be added!</h3>';
        echo '<span style="text-align: center;">Error: ' . $sql . '<br>' . $con->error . '</span>';
    }
}

if (isset($_POST['commentdelete'])) {
    $tid = mysqli_real_escape_string($con, $_POST['tid']);
    $cid = mysqli_real_escape_string($con, $_POST['cid']);

    $sql = "DELETE FROM comments WHERE comment_id=".$cid;

    if ($con->query($sql) === TRUE) {
        header("Location: task-info.php?i=".$tid);
    } else {
        echo '<h3 style="text-align: center;">The comment could not be deleted!</h3>';
        echo '<span style="text-align: center;">Error: ' . $sql . '<br>' . $con->error . '</span>';
    }
}

//check if form is submitted
if (isset($_POST['taskedit'])) {
    $tid = mysqli_real_escape_string($con, $_POST['tid']);
    $timg = mysqli_real_escape_string($con, $_POST['timg']);
	$tname = mysqli_real_escape_string($con, $_POST['task-name']);
	$tdesc = mysqli_real_escape_string($con, htmlspecialchars($_POST['task-desc']));
    $tstate = mysqli_real_escape_string($con, $_POST['task_state']);
    $ttype = mysqli_real_escape_string($con, $_POST['task_media_type']);
    $tass = mysqli_real_escape_string($con, $_POST['task_assigned']);
    if(isset($_FILES['task_media'])) {
        if($_FILES['task_media']['name'] == "") {
            $newtimage = $timg;
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
    
    $sql = "UPDATE tasks SET task_name='".$tname."', task_desc='".$tdesc."', task_state='".$tstate."', task_media_type='".$ttype."', task_media='".$newtimage."', task_assigned='".$tass."' WHERE task_id='".$tid."'";

    if ($con->query($sql) === TRUE) {
        header("Location: task-info.php?i=".$tid);
    } else {
        echo '<h3 style="text-align: center;">The task could not be edited!</h3>';
        echo '<span style="text-align: center;">Error: ' . $sql . '<br>' . $con->error . '</span>';
    }
}

$result = mysqli_query($con, "SELECT * FROM tasks WHERE task_id = '" . $taskID. "'");
if ($row = mysqli_fetch_array($result)) {
?>
<div class="row">
    <div class="col-md-7">
        <div class="card">
            <?php if ($row['task_media_type']=="img") { ?>
            <img class="card-img-top img-fluid" width="100%" src="uploads/<?php echo $row['task_media'];?>" onError="this.onerror=null;this.src='uploads/no-media.jpg';" alt="<?php echo $row['task_name'];?>">
            <?php } if ($row['task_media_type']=="vid") { ?>
            <video controls class="card-img-top img-fluid" width="100%">
                <source src="uploads/<?php echo $row['task_media'];?>" type="video/mp4">
            </video>
            <?php } ?>
            <div class="card-block">
                <h4 class="card-title">Comments:</h4>
                <hr>
                <p class="card-text">
                <?php
                    $newresult = mysqli_query($con, "SELECT * FROM comments WHERE task_id = '" . $taskID. "'");
                    while($rownew = mysqli_fetch_array($newresult)){ ?>
                        
                         <form role="form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" name="commentdeleteform">
                             <b><?php echo $rownew['user_name']; ?></b>: <?php echo $rownew['comment_text']; ?>
                            <input type="hidden" name="tid" id="tid" value="<?php echo $taskID;?>">
                            <input type="hidden" name="cid" id="cid" value="<?php echo $rownew['comment_id']; ?>">
                            <?php if ($_SESSION['nited_usr_type']!="guest" && $_SESSION['nited_usr_name']==$rownew['user_name']) { ?>
                            <button class="btn btn-warning btn-sm float-md-right" style="display: inline;" type="submit" name="commentdelete">Delete</button>
                            <?php } ?>
                        </form><hr>
                <?php } ?>
                </p>
                <form class="form-inline" role="form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" name="taskcommentform">
                    <input type="hidden" name="tid" id="tid" value="<?php echo $taskID;?>">
                    <?php if ($_SESSION['nited_usr_type']!="guest") { ?>
                    <input type="text" class="form-control col-2 col-sm-2 col-sm-0" style="width: 82%;" id="comment_item" name="comment_item">
                    <button class="btn btn-primary" type="submit" name="taskcomment">Comment</button>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card">
            <div class="card-block">
                <h4 class="card-title"><?php echo $row['task_name'];?><span class="badge badge-default float-xs-right" style="font-size: 15px; margin-top: 5px;"><?php echo $row['task_state']; ?></span></h4>
                <?php if($row['task_assigned']!="None") { ?>
                <p>Assigned to: <?php echo $row['task_assigned']; ?></p>
                <?php } ?>
                <hr>
                <p class="card-text"><?php echo $row['task_desc'];?></p>
                <form role="form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" name="taskdeleteform">
                    <input type="hidden" name="tid" id="tid" value="<?php echo $taskID;?>">
                    <?php if ($_SESSION['nited_usr_type']!="guest") { ?>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#taskEditModal">
                        Edit Task
                    </button>
                    <button class="btn btn-danger" type="submit" name="taskdelete">Close Task</button>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="taskEditModal" tabindex="-1" role="dialog" aria-labelledby="taskEditModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Edit Task</h5>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" role="form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" name="taskeditform" >
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Task Name" value="<?php echo $row['task_name'];?>" id="task-name" name="task-name" required>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" id="task-desc" name="task-desc" required rows="3" placeholder="Task Description"><?php echo $row['task_desc'];?></textarea>
                    </div>
                    <div class="form-group">
                        <label>File Type:</label>
                        <select class="form-control" id="task_media_type" name="task_media_type">
                            <option value="img" <?=$row['task_media_type'] == 'img' ? 'selected="selected"' : '';?>>Image</option>
                            <option value="vid" <?=$row['task_media_type'] == 'vid' ? 'selected="selected"' : '';?>>Video</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>File:</label>
                        <input type="file" class="form-control" id="task_media" name="task_media">
                    </div>
                    <div class="form-group">
                        <label>Task State:</label>
                        <select class="form-control" id="task_state" name="task_state">
                            <option value="Final" <?=$row['task_state'] == 'Final' ? 'selected="selected"' : '';?>>Final</option>
                            <option value="In Progress" <?=$row['task_state'] == 'In Progress' ? 'selected="selected"' : '';?>>In Progress</option>
                            <option value="Missing File" <?=$row['task_state'] == 'Missing File' ? 'selected="selected"' : '';?>>Missing File</option>
                            <option value="Not Active" <?=$row['task_state'] == 'Not Active' ? 'selected="selected"' : '';?>>Not Active</option>
                            <option value="Not Assigned" <?=$row['task_state'] == 'Not Assigned' ? 'selected="selected"' : '';?>>Not Assigned</option>
                            <option value="On Hold" <?=$row['task_state'] == 'On Hold' ? 'selected="selected"' : '';?>>On Hold</option>
                            <option value="Redo" <?=$row['task_state'] == 'Redo' ? 'selected="selected"' : '';?>>Redo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Assigned To:</label>
                        <select class="form-control" id="task_assigned" name="task_assigned">
                            <option value="None" <?=$row['task_assigned'] == 'None' ? 'selected="selected"' : '';?>>None</option>
                            <?php
                            $result_users = mysqli_query($con, "SELECT * FROM users");
                            while($row_users = mysqli_fetch_array($result_users)){ ?>
                                <option value="<?php echo $row_users['name']; ?>" <?=$row['task_assigned'] == $row_users['name'] ? 'selected="selected"' : '';?>><?php echo $row_users['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <input type="hidden" name="tid" id="tid" value="<?php echo $taskID;?>">
                    <input type="hidden" name="timg" id="timg" value="<?php echo $row['task_media'];?>">
                    <button class="btn btn-primary btn-lg btn-block" type="submit" name="taskedit">Update Task</button>
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
