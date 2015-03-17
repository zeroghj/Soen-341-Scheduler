<!DOCTYPE html>
<html lang="en">
<?php
function __autoload($classname) {
    include($classname.".php");   
}
include_once('database_info.php');
session_start();
if(!isset($_SESSION['User'])){
header("location:../index.php");
}
?>
	<head>
		<meta charset="utf-8" />

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<title>Student Courses</title>
		<meta name="description" content="student's course information page" />
		<meta name="author" content="mk" />

		<meta name="viewport" content="width=device-width; initial-scale=1.0" />

		
		<link rel="shortcut icon" href="../favicon.ico" />
		<link rel="stylesheet" href="../css/normalize.css">
        <link rel="stylesheet" href="../css/main.css">
        <script src="../js/vendor/modernizr-2.6.2.min.js"></script>
        
        
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,700,300italic,600' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="../css/customization_root.css">
		<link rel="stylesheet" href="../css/student_page.css" />
		
	</head>

	<body>
		<div>
			<header>
				<h1 id="title_teacherName">Hello, <?php print($_SESSION["User"]->getfname() . " " . $_SESSION["User"]->getlname());?></h1>
				<span id="ID_teacher">ID : <?php print($_SESSION["User"]->getid());?></span>
				<nav>
					<a href="ChangePassword.php">Account</a>
					<a href="../index.php">Logout</a>
				</nav>
			</header>
			<div class="pullDown"> </div>
			<section class="main">
			<div id="temp"> </div>
				<h2>Users </h2>
				
				<table id="tableClassesSelected" class="tableClassesSelected">
					<tr class="tableHeader"> 
						<th>User ID</th> 
						<th>First Name</th> 
						<th>Last Name</th> 
						<th>User Type</th>  
					</tr>
					<?php $_SESSION["User"]->DisplayUsers();?>
				</table>
	</div>
				
				
				
			

			<footer class="gapper20">
			</footer>
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>')</script>
        <script src="../js/plugins.js"></script>
        <script src="../js/main.js"></script>
	</body>
</html>
