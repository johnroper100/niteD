<?php
session_start();
if(isset($_SESSION['nited_usr_id'])=="") {
	header("Location: login.php");
}

include_once 'dbconnect.php';
include 'header.php';

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

function truncate($string,$length=100,$append="&hellip;") {
  $string = trim($string);

  if(strlen($string) > $length) {
    $string = wordwrap($string, $length);
    $string = explode("\n", $string, 2);
    $string = $string[0] . $append;
  }

  return $string;
}
?>
<div class="row masonry-container">
<?php
$result = mysqli_query($con, "SELECT * FROM tasks");

while($row = mysqli_fetch_array($result)){ ?>
    <div class="col-md-4 item">
        <div class="card" >
            <?php if ($row['task_media_type']=="img") { ?>
            <img class="card-img-top img-fluid" width="100%" src="uploads/<?php echo $row['task_media'];?>" onError="this.onerror=null;this.src='uploads/no-media.jpg';" alt="<?php echo $row['task_name'];?>">
            <?php } if ($row['task_media_type']=="vid") { ?>
            <video controls class="card-img-top img-fluid" width="100%">
                <source src="uploads/<?php echo $row['task_media'];?>" type="video/mp4">
            </video>
            <?php } ?>
            <div class="card-block">
                <h4 class="card-title"><?php echo $row['task_name']; ?><span class="badge badge-default float-xs-right" style="font-size: 15px; margin-top: 5px;"><?php echo $row['task_state']; ?></span></h4>
                <hr>
                <p class="card-text"><?php echo truncate($row['task_desc']); ?></p>
                <form role="form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" name="taskdeleteform">
                    <input type="hidden" name="tid" id="tid" value="<?php echo $row['task_id']; ?>">
                    <a href="task-info.php?i=<?php echo $row['task_id']; ?>" class="btn btn-primary">View Task</a>
                    <?php if ($_SESSION['nited_usr_type']!="guest") { ?>
                    <button class="btn btn-danger" type="submit" name="taskdelete">Close Task</button>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
<?php } ?>
</div>
<?php include 'footer.php'; ?>
