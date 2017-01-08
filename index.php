<?php
session_start();

if(isset($_SESSION['nited_usr_id'])!="") {
	header("Location: tasks.php");
} else {
    header("Location: login.php");
}

?>