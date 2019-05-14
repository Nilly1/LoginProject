<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
}
require_once "repository.php";

// Update a user last update time in DB (a user is still connected) 
$username = $_POST[USERNAME];
UsersRepository::Instance()->ChangeLastUpdateTime($username);

// Get the list of all connected users
$all_users = UsersRepository::Instance()->GetAllConnectedUsers();
echo json_encode($all_users);
?>