<?php 
include('Student.php');
	session_start();
	if(!isset($_SESSION['User'])){
header("location:../index.php");
}
$_SESSION["User"]->changePassword($_POST['oldPassword'],$_POST['newPassword']);

?>