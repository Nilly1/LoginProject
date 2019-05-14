<?php
require_once "repository.php";
require_once "user.php";

RegisterUser("gary","KAEYZwZxi");
RegisterUser("marius","i8HhO4SDR");
RegisterUser("debora","f7L199xe");
RegisterUser("kevin","t9Dc2lHpvq");
RegisterUser("alica","D0sXeQdMk9o9");
RegisterUser("susi","ptVtLOPIA");
RegisterUser("riki","HeNUgv");
RegisterUser("alaster","rIxKmov50");
RegisterUser("mark","aCSiCD");
RegisterUser("john","wMpHJwmdF9Dr");

echo 'Adding users is done';

function RegisterUser($name,$pass)
{
    if (isset($name)) {
        $user = new User($name, $pass);
        UsersRepository::Instance()->AddUser($user);
    }
}

?>