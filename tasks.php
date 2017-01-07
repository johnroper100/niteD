<?php
session_start();
include_once 'dbconnect.php';
include 'header.php';
?>
<div class="row masonry-container">
<?php
$result = mysqli_query($con, "SELECT * FROM tasks");

while($row = mysqli_fetch_array($result)){
    echo '<div class="col-md-4 item">';
    echo '<div class="card" >';
    echo '<img class="card-img-top img-fluid" width="100%" src="uploads/'.$row['image'].'" alt="'.$row['name'].'">';
    echo '<div class="card-block">';
    echo '<h4 class="card-title">'.$row['name'].'</h4>';
    echo '<p class="card-text">'.$row['desc'].'</p>';
    echo '<a href="page.php?tid='.$row['id'].'" class="btn btn-primary">View Task</a>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    
}
?>
</div>
<?php include 'footer.php'; ?>
