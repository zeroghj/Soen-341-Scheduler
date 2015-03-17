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
				<h1 id="title_studentName">Hello, <?php print($_SESSION["User"]->getfname() . " " . $_SESSION["User"]->getlname());?></h1>
				<span id="ID_student">ID : <?php print($_SESSION["User"]->getid());?></span>
				<nav>
					<a href="ChangePassword.php">Account</a>
					<a href="../index.php">Logout</a>
				</nav>
			</header>
			<div class="pullDown"> </div>
			<section class="main">
			<div id="temp"> </div>
				<h2>Courses Taken </h2>
				
				<table id="tableClassesSelected" class="tableClassesSelected">
					<tr class="tableHeader"> 
						<th>Section Name</th> 
						<th>Course ID</th> 
						<th>Faculty</th> 
						<th>Session</th>  
						<th>Room</th> 
						<th>Tutorial</th> 
						<th colspan="2">Lab</th>  
					</tr>
				</table>
				
				<div class="pullDown"></div>
				
				<h2 class="inliner" >Choose Courses</h2> <span id="courseErrorSpace" class="errorSpace"></span>
				<div class="pullDown"></div>
				<!-- Constraints will arrive here... Vincent's page MUST be replaced!-->
				<form action="hopefullytemporary.php" method="post" autocomplete="on">
					<section class="constraints">
						
						<div id="pickDays">
							<h3>Include days</h3>
							<div> <input type="checkbox" name="day[]" value="M" checked="checked"><label for="day">Mon</label> </div>
							<div> <input type="checkbox" name="day[]" value="T" checked="checked"><label for="day">Tue</label> </div>
							<div> <input type="checkbox" name="day[]" value="W" checked="checked"><label for="day">Wed</label> </div>
							<div> <input type="checkbox" name="day[]" value="J" checked="checked"><label for="day">Thu</label> </div>
							<div> <input type="checkbox" name="day[]" value="F" checked="checked"><label for="day">Fri</label> </div>
							<div> <input type="checkbox" name="day[]" value="S" checked="checked"><label for="day">Sat</label> </div>
						</div>
						
						<div id="pickTime">
							<h3>Select time interval</h3>
							<label>From</label>
							<select id = "timeFrom" name="timeFrom">
							   <option value = "00:00:00" selected="selected">00:00 AM</option>
							   <option value = "01:00:00">01:00 AM</option>
							   <option value = "02:00:00">02:00 AM</option>
							   <option value = "03:00:00">03:00 AM</option>
							   <option value = "04:00:00">04:00 AM</option>
							   <option value = "05:00:00">05:00 AM</option>
							   <option value = "06:00:00">06:00 AM</option>
							   <option value = "07:00:00">07:00 AM</option>
							   <option value = "08:00:00">08:00 AM</option>
							   <option value = "09:00:00">09:00 AM</option>
							   <option value = "10:00:00">10:00 AM</option>
							   <option value = "11:00:00">11:00 AM</option>
							   <option value = "12:00:00">12:00 PM</option>
							   <option value = "13:00:00">01:00 PM</option>
							   <option value = "14:00:00">02:00 PM</option>
							   <option value = "15:00:00">03:00 PM</option>
							   <option value = "16:00:00">04:00 PM</option>
							   <option value = "17:00:00">05:00 PM</option>
							   <option value = "18:00:00">06:00 PM</option>
							   <option value = "19:00:00">07:00 PM</option>
							   <option value = "20:00:00">08:00 PM</option>
							   <option value = "21:00:00">09:00 PM</option>
							   <option value = "22:00:00">10:00 PM</option>
							   <option value = "23:00:00">11:00 PM</option>
							</select>
							
							<label>To</label>
							<select id = "timeTo" name="timeTo">
							   <option value = "00:00:00">00:00 AM</option>
							   <option value = "01:00:00">01:00 AM</option>
							   <option value = "02:00:00">02:00 AM</option>
							   <option value = "03:00:00">03:00 AM</option>
							   <option value = "04:00:00">04:00 AM</option>
							   <option value = "05:00:00">05:00 AM</option>
							   <option value = "06:00:00">06:00 AM</option>
							   <option value = "07:00:00">07:00 AM</option>
							   <option value = "08:00:00">08:00 AM</option>
							   <option value = "09:00:00">09:00 AM</option>
							   <option value = "10:00:00">10:00 AM</option>
							   <option value = "11:00:00">11:00 AM</option>
							   <option value = "12:00:00">12:00 PM</option>
							   <option value = "13:00:00">01:00 PM</option>
							   <option value = "14:00:00">02:00 PM</option>
							   <option value = "15:00:00">03:00 PM</option>
							   <option value = "16:00:00">04:00 PM</option>
							   <option value = "17:00:00">05:00 PM</option>
							   <option value = "18:00:00">06:00 PM</option>
							   <option value = "19:00:00">07:00 PM</option>
							   <option value = "20:00:00">08:00 PM</option>
							   <option value = "21:00:00">09:00 PM</option>
							   <option value = "22:00:00">10:00 PM</option>
							   <option value = "23:00:00" selected="selected">11:00 PM</option>
							</select>
						</div>
						
						<div id="pickSemester">
							<h3>Select courses from semester(s)</h3>
							<select id = "semester" name="semester">
							   <option value = "Summer">Summer</option>
							   <option value = "Winter">Winter</option>
							   <option value = "Fall">Fall</option>
							   <option value = "All" selected="selected">ALL</option>
							</select>
						</div>
					</section>
					<div class="gapper20"></div>
					<input type="submit" value="Update Constraints" class="buttons">
				</form>
				
				
				<div class="gapper20"></div>
				<table id="scheduler">
					<tr class="noClick">
						<th>Course</th>
						<th>Course Name</th>
						<th>Course Credits</th>
						<th>Course Session</th>
						<th>Course Prerequisite(s)</th>
					</tr>
				<!--<tr>
						<td colspan="5" id="loadMore">
							Load/Load More
						</td>   
					</tr> -->
				</table>
			</section>

			<footer class="gapper20">
			</footer>
		</div>
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>')</script>
        <script src="../js/plugins.js"></script>
        <script src="../js/main.js"></script>
		<script src="../js/ajaxCall.js"></script>
		<script src="../js/student_page.js"></script>
	</body>
</html>
