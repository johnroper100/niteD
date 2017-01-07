<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags always come first -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <nav class="navbar navbar-dark bg-inverse">
            <a href="tasks.php"><h1 class="navbar-brand mb-0" style="margin-left: 25px;">niteD</h1></a>
            <?php if (isset($_SESSION['usr_id'])) { ?>
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="add-task.php">Add Task</a></li>
                <li class="nav-item"><a class="nav-link" href="add-user.php">Add User</a></li>
                <li class="nav-item dropdown float-md-right" style="margin-right: 25px;">
                    <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-user fa-lg" style="font-size: 25px; margin-right: 5px;"></span> <?php echo $_SESSION['usr_name']; ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
            <?php } ?>
        </nav>
        <div class="container">
