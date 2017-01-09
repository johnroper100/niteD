<?php
include_once 'dbconnect.php';
include 'header.php';

//set validation error flag as false
$error = false;

//check if form is submitted
if (isset($_POST['projectcreate'])) {
	$pname = mysqli_real_escape_string($con, $_POST['project-name']);
    $pemail = mysqli_real_escape_string($con, $_POST['project-email']);
    $purl = mysqli_real_escape_string($con, $_POST['project-url']);
	$pdesc = mysqli_real_escape_string($con, htmlspecialchars($_POST['project-description']));
    
    $sql = "CREATE TABLE IF NOT EXISTS `project` (`project_name` varchar(50) NOT NULL, `project_email` varchar(30) NOT NULL, `project_url` varchar(100) NOT NULL, `project_description` text NOT NULL)";
    $sql2 = "CREATE TABLE IF NOT EXISTS `users` (`id` int NOT NULL PRIMARY KEY AUTO_INCREMENT, `name` varchar(30) NOT NULL, `email` varchar(60) NOT NULL, `password` varchar(40) NOT NULL, `account_type` varchar(30) NOT NULL, UNIQUE KEY `email` (`email`))";
    $sql3 = "INSERT INTO `users` (`id`, `name`, `email`, `password`, `account_type`) VALUES (1, 'Administrator', 'admin@admin.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'admin')";
    $sql4 = "CREATE TABLE IF NOT EXISTS `tasks` (`task_id` int NOT NULL PRIMARY KEY AUTO_INCREMENT, `task_name` varchar(50) NOT NULL, `task_desc` text NOT NULL, `task_state` varchar(20) NOT NULL, `task_media_type` varchar(20) NOT NULL, `task_media` text NOT NULL, UNIQUE KEY `task_id` (`task_id`))";
    $sql5 = "CREATE TABLE IF NOT EXISTS `comments` (`comment_id` int NOT NULL PRIMARY KEY AUTO_INCREMENT, `user_name` varchar(50) NOT NULL, `comment_text` text NOT NULL, `task_id` int NOT NULL, UNIQUE KEY `comment_id` (`comment_id`))";
    $sql6 = "INSERT INTO project (project_name, project_email, project_url, project_description) VALUES ('".$pname."', '".$pemail."', '".$purl."', '".$pdesc."')";
    if ($con->query($sql) === TRUE && $con->query($sql2) === TRUE && $con->query($sql3) === TRUE && $con->query($sql4) === TRUE && $con->query($sql5) === TRUE && $con->query($sql6) === TRUE) {
        echo '<h3 style="text-align: center;">The project was created! Click <a href="logout.php">here</a> to start using niteD.</h3>';
        header("Location: logout.php");
    } else {
        echo '<h3 style="text-align: center;">The project could not be created!</h3>';
        echo '<span style="text-align: center;">Error: ' . $sql . '<br>' . $con->error . '</span>';
    }
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-block">
                <h4 class="card-title">Install niteD</h4>
                <p class="card-text">To install niteD you first have to input some info about your project.<br>Once you get to the login page, use this info:<br><br><b>Email:</b> admin@admin.com<br><b>Password:</b> password<br><br>Then you can add yourself as a user and/or change the password.<br><b>You must remember to delete <i>install.php</i> so that nobody can access your website!</b></p>
                <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="projectcreateform" >
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Project Name" id="project-name" name="project-name" required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Project Email" id="project-email" name="project-email" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Project URL" id="project-url" name="project-url" required>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" id="project-description" name="project-description" required rows="3" placeholder="Project Description"></textarea>
                    </div>
                    <button class="btn btn-primary btn-lg btn-block" type="submit" name="projectcreate">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
