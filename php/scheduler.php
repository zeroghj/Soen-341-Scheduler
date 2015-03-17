<?php
include('Student.php');
session_start();
$_SESSION['User']->DisplayAvailableCourses();
?>


