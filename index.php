<?php
session_start();

if(isset($_SESSION['usr_id'])!="") {
	header("Location: tasks.php");
} else {
    header("Location: login.php");
}

?>