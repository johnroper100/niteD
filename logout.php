<?php
session_start();

if(isset($_SESSION['nited_usr_id'])) {
	session_destroy();
	unset($_SESSION['nited_usr_id']);
	unset($_SESSION['nited_usr_name']);
	header("Location: login.php");
} else {
	header("Location: login.php");
}
?>