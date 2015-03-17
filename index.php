<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<?php
function __autoload($classname) {
    include($classname.".php");   
}
if(isset($_SESSION['User'])){
session_destroy();}
?>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Scheduler: login</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
		
		<link rel="shortcut icon" href="favicon.ico" />
		<link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
        
        <link href='http://fonts.googleapis.com/css?family=Inder' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="css/customization_root.css" />
		
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
		
		<header>
		</header>
		<section id="login">
			<h1>Welcome to Student Scheduler.</h1>
			<form name="loginform" method="post" action="php/password.php"><!--Added by Vincent for testing-->
			<div>
				<label for="ID_user" >ID</label>
				<input type="text" name="ID_user" id="ID_user"/>
			</div>
			<div>
				<label for="password_user" >Password</label>
				<input type="password" name="password_user" id="password_user"/>
				<div class="pullDown"> </div>
				<input type="radio" name="usertype" value="2" checked="checked">Student
				<input type="radio" name="usertype" value="1">Teacher
				<input type="radio" name="usertype" value="0">Admin
				<input type="submit" name="Submit" value="Login" class="buttons"><!--Added by Vincent for testing-->
			</div>
			</form><!--Added by Vincent for testing-->
			<div class="pullDown"> </div>
		</section>
		
		
		
        

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>')</script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>

    </body>
</html>
