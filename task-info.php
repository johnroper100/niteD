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
    $cname = $_SESSION['usr_name'];
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

$result = mysqli_query($con, "SELECT * FROM tasks WHERE task_id = '" . $taskID. "'");
if ($row = mysqli_fetch_array($result)) {
?>
<div class="row">
    <div class="col-md-7">
        <div class="card">
            <img class="card-img-top img-fluid" width="100%" src="uploads/<?php echo $row['task_image'];?>" alt="<?php echo $row['task_name'];?>">
            <div class="card-block">
                <h4 class="card-title">Comments:</h4>
                <hr>
                <p class="card-text">
                <?php
                    $newresult = mysqli_query($con, "SELECT * FROM comments WHERE task_id = '" . $taskID. "'");
                    while($rownew = mysqli_fetch_array($newresult)){ ?>
                        
                         <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="commentdeleteform">
                             <b><?php echo $rownew['user_name']; ?></b>: <?php echo $rownew['comment_text']; ?>
                            <input type="hidden" name="tid" id="tid" value="<?php echo $taskID;?>">
                            <input type="hidden" name="cid" id="cid" value="<?php echo $rownew['comment_id']; ?>">
                            <?php if ($_SESSION['usr_type']!="guest") { ?>
                            <button class="btn btn-warning btn-sm float-md-right" style="display: inline;" type="submit" name="commentdelete">Delete</button>
                            <?php } ?>
                        </form><hr>
                <?php } ?>
                </p>
                <form class="form-inline" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="taskcommentform">
                    <input type="hidden" name="tid" id="tid" value="<?php echo $taskID;?>">
                    <?php if ($_SESSION['usr_type']!="guest") { ?>
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
                <h4 class="card-title"><?php echo $row['task_name'];?></h4>
                <p class="card-text"><?php echo $row['task_desc'];?></p>
                <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="taskdeleteform">
                    <input type="hidden" name="tid" id="tid" value="<?php echo $taskID;?>">
                    <?php if ($_SESSION['usr_type']!="guest") { ?>
                    <button class="btn btn-danger" type="submit" name="taskdelete">Close Task</button>
                    <?php } ?>
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
