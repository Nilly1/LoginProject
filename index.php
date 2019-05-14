<?php
require "./php/consts.php";

session_start();

if (isset($_SESSION[LOGIN_OK])) {
    header("location:./php/connected.php"); // User is already logged-in
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">    
		<link href="./css/bootstrap.css" rel="stylesheet" media="screen">
		<link href="./css/main.css" rel="stylesheet" media="screen">
	</head>
    <body>
    	<div class="container">
	        <form class="form-signin" method="post" action="./index.php">
	            <h2 class="form-signin-heading">Sign in</h2>
	        	<input name="username" id="username" type="text" class="form-control" placeholder="Username" autofocus>
	        	<input name="password" id="password" type="password" class="form-control" placeholder="Password">
	        	<button name="Submit" id="submit" class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>

	        	<div id="message" class="message"></div>
	        </form>
	    </div> <!-- /container -->
    </body>

    <script src="./js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="./js/bootstrap.js"></script>
    <script src="./js/login.js"></script>

</html>
