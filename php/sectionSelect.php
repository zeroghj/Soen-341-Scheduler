<?php
include('Student.php');
session_start();
$_SESSION['User']->addClasses($_POST['classid'], $_POST['courseid']);
?>