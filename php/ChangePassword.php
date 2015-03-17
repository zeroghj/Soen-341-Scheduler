<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<?php
include('student.php');
session_start();
if(!isset($_SESSION['User'])){
header("location:..//index.php");
}
?>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Account: Change password</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,700,300italic,600' rel='stylesheet' type='text/css'>
		<link rel="shortcut icon" href="../favicon.ico" />
		<link rel="stylesheet" href="../css/normalize.css">
        <link rel="stylesheet" href="../css/main.css">
		
		<link rel="stylesheet" href="../css/customization_root.css">
		<link rel="stylesheet" href="../css/ChangePassword.css" />
        
		<script src="../js/vendor/modernizr-2.6.2.min.js"></script>
        
		
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
		
		<header>
				<h1 id="title_studentName">Hello, <?php print($_SESSION["User"]->getfname() . " " . $_SESSION["User"]->getlname());?></h1>
				<span id="ID_student">ID : <?php print($_SESSION["User"]->getid());?></span>
				<nav>
					<a href="student_page.php">Home</a>
					<a href="/account_student.html">Account</a>
					<a href="../index.php">Logout</a>
				</nav>
		</header>
		<div class="pullDown"> </div>
		<section class="main">
			<form action="hopefullytemporary2.php" method="post" autocomplete="on" id="changePassword">
				<div>
					<label for="oldPassword">Old Password</label>
					<input type="password" id="oldPassword" name="oldPassword"></input>
					<div class="errorSpace"> </div>
				</div>
				<div>
					<label for="newPassword">New Password</label>
					<input type="password" id="newPassword" name="newPassword"></input>
					<div class="errorSpace"> </div>
				</div>
				<div>
					<label for="confirmPassword">Confirm Password</label>
					<input type="password" id="confirmPassword" name="confirmPassword"></input>
					<div class="errorSpace"> </div>
				</div>
				<div class="gapper20"></div>
				<input type="submit" class="buttons" value="Update Password" id="PWsubmit"></input>
			</form>
		
		</section>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="../js/vendor/jquery-1.9.1.min.js"><\/script>')</script>
        <script src="../js/plugins.js"></script>

    </body>
</html>