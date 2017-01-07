<?php
session_start();
if(isset($_SESSION['usr_id'])=="") {
	header("Location: login.php");
}

include_once 'dbconnect.php';
include 'header.php';
?>
<div class="row masonry-container">
<?php
$result = mysqli_query($con, "SELECT * FROM tasks");

while($row = mysqli_fetch_array($result)){
    echo '<div class="col-md-4 item">';
    echo '<div class="card" >';
    echo '<img class="card-img-top img-fluid" width="100%" src="uploads/'.$row['task_image'].'" alt="'.$row['task_name'].'">';
    echo '<div class="card-block">';
    echo '<h4 class="card-title">'.$row['task_name'].'</h4>';
    echo '<p class="card-text">'.$row['task_desc'].'</p>';
    echo '<a href="task-info.php?i='.$row['task_id'].'" class="btn btn-primary">View Task</a>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    
}
?>
</div>
<?php include 'footer.php'; ?>
