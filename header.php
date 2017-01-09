<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags always come first -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        
        <?php
        include_once 'dbconnect.php';
        $result_login = mysqli_query($con, "SELECT * FROM project");
        if ($row_login = mysqli_fetch_array($result_login)) {
            $login_project = $row_login['project_name']." |";
            $login_project_title = $row_login['project_name'];
            $login_project_desc = $row_login['project_description'];
        } else {
            $login_project = "";
            $login_project_title = "niteD";
            $login_project_desc = "";
        }
        ?>
        
        <title><?php echo $login_project; ?> niteD - Project Management System</title>
        
        <!-- Facebook Stuff --> 
        <meta property="og:title" content="<?php echo $login_project; ?> niteD - Project Management System"> 
        <meta property="og:type" content="website"> 
        <meta property="og:url" content="http://jmroper.com/">
        <meta property="og:description" content="<?php echo $login_project_desc; ?>">
        <!-- Twitter Stuff --> 
        <meta name="twitter:card" content="summary">
        <meta name="twitter:site" content="@johnroper100">
        <meta name="twitter:creator" content="@johnroper100">
        <meta name="twitter:title" content="<?php echo $login_project; ?> niteD - Project Management System">
        <meta name="twitter:description" content="<?php echo $login_project_desc; ?>">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <nav class="navbar navbar-dark bg-inverse">
            <a href="tasks.php"><h1 class="navbar-brand mb-0" style="margin-left: 25px;"><?php echo $login_project_title; ?></h1></a>
            <?php if (isset($_SESSION['nited_usr_id'])) {
                //check if form is submitted
                if (isset($_POST['passedit'])) {
                    $uid = mysqli_real_escape_string($con, $_SESSION['nited_usr_id']);
                    $upass = mysqli_real_escape_string($con, $_POST['upass']);

                    $sql = "UPDATE users SET password='".md5($upass)."' WHERE id='".$uid."'";

                    if ($con->query($sql) === TRUE) {
                        header("Location: tasks.php");
                    } else {
                        echo '<h3 style="text-align: center;">The user password could not be edited!</h3>';
                        echo '<span style="text-align: center;">Error: ' . $sql . '<br>' . $con->error . '</span>';
                    }
                }
            ?>
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="stats.php">Stats</a></li>
                <?php if ($_SESSION['nited_usr_type']!="guest" || $_SESSION['nited_usr_type']!="rev") { ?>
                <li class="nav-item"><a class="nav-link" href="add-task.php">Add Task</a></li>
                <?php } if ($_SESSION['nited_usr_type']=="admin" || $_SESSION['nited_usr_type']=="mod") { ?>
                    <li class="nav-item"><a class="nav-link" href="add-user.php">Add User</a></li>
                <?php } ?>
                <li class="nav-item dropdown float-md-right" style="margin-right: 25px;">
                    <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-user fa-lg" style="font-size: 25px; margin-right: 5px;"></span> <?php echo $_SESSION['nited_usr_name']; ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#passEditModal">Update Password</a>
                        <?php if ($_SESSION['nited_usr_type']=="admin" || $_SESSION['nited_usr_type']=="mod") { ?>
                            <a class="dropdown-item" href="users.php">Users</a>
                        <?php } ?>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
            <div class="modal fade" id="passEditModal" tabindex="-1" role="dialog" aria-labelledby="passEditModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="modal-title" id="exampleModalLabel">Edit Password</h5>
                    </div>
                    <div class="modal-body">
                        <form role="form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" name="passeditform">
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Password" id="upass" name="upass">
                            </div>
                            <button class="btn btn-danger" type="submit" name="passedit">Update Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
            <?php } ?>
        </nav>
        <div class="container">
