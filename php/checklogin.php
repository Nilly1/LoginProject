<?php
require_once "repository.php";
require_once "consts.php";

if(!isset($_SESSION)) 
{ 
    session_start(); 
}

$username = $_POST[USERNAME];
$password = $_POST[PASS];
$_SESSION[USERNAME] = $username;

$response = false;

// Check if requested name is taken
$is_user_exists = UsersRepository::Instance()->IsUserExists($username);

if ($is_user_exists)
{
	// Test if username and password fits together
	$is_login_succ = UsersRepository::Instance()->IsLoginOK($username,$password);

	if ($is_login_succ){
		$response = true;
		$_SESSION[LOGIN_OK] = true; // Session is valid
		UsersRepository::Instance()->ChangeLastLoginTime($username); // Update last login time
	}
}

echo json_encode($response);