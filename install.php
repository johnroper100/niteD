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
    
    $sql = "INSERT INTO project (project_name, project_email, project_url, project_description) VALUES ('".$pname."', '".$pemail."', '".$purl."', '".$pdesc."')";

    if ($con->query($sql) === TRUE) {
        header("Location: login.php");
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
                <p class="card-text">To install niteD you first have to input some info about your project.<br>Once you get to the login page, use this info:<br><br><b>Email:</b> admin@admin.com<br><b>Password:</b> password<br><br>Then you can add yourself as a user, and/or change the password.</p>
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
