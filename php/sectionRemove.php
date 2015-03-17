<?php
include('Student.php');
session_start();
$_SESSION['User']->removeClasses($_POST['classid'], $_POST['courseid']);
?>