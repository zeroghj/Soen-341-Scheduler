<?php 
include('Student.php');
	session_start();
	if(!isset($_SESSION['User'])){
header("location:../index.php");
}
$_SESSION["User"]->setSelection($_POST['day'], $_POST['timeFrom'], $_POST['timeTo'], $_POST['semester']);
header("location:student_page.php");

?>