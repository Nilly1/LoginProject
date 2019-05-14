<?php 
require_once "consts.php";

session_start();

if (!$_SESSION[LOGIN_OK])
{
  header("location:../index.php"); // User is not connected. Display sign-in form.
}

$user = $_SESSION[USERNAME];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="../css/main.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  </head>
  <body>
    <div class="container">
      <div class="form-connected">
        <div class="alert alert-success">
        	<p>Welcome <span class="logged-user"><?php echo $user; ?></span>,</p>
        	<p>You have been <strong>successfully logged in</strong>.</p>
        </div>        
        <a href="logout.php" class="btn btn-default btn-lg btn-block">Logout</a>
      </div>
      <div class="table-data table-responsive">
      	<h1 class="table-title">Logged in users</h1>
        <table id='all-users-table' class='all-users'>
        	<thead>
		      <tr>
		          <th>Username</th>
		          <th>Login Time</th>		          
		          <th>Update Time</th>
		          <th>IP</th>
		      </tr>
		    </thead>
        </table>
        <div id="message" class="message"></div>
      </div> <!-- table-data -->
    </div> <!-- /container -->
  </body>

    <script src="../js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.js"></script>
    <script src="../js/pulse.js"></script>
    <script type="text/javascript" charset="utf8" src="../js/jquery.dataTables.min.js"></script>
</html>