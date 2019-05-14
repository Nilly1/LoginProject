<?php
require_once "functions.php";

/*
* User
* Holds a single user data
*/
class User
{
    private $username;
    private $password;
    private $login_time;
    private $update_time;
    private $ip;
    private $salt;

    public function User($username, $password)
    {        
        $date = GetTime();
        $this->set_username($username);
        $this->set_password($password);
        $this->set_login_time($date);
        $this->set_update_time($date);
        $this->ip = $this->GetUserIpAddr();
    }

    public function get_username()
    {
        return $this->username;
    }

    public function set_username($value)
    {
        $this->username = $value;
    }

    public function get_password()
    {
        return $this->password;
    }

    public function set_password($value)
    {
        $this->password = $value;
    }
    public function get_salt()
    {
        return $this->salt;
    }

    public function set_salt($value)
    {
        $this->salt = $value;
    }
    public function get_login_time()
    {
        return $this->login_time;
    }

    public function set_login_time($value)
    {
        $this->login_time = $value;
    }
    public function get_update_time()
    {
        return $this->update_time;
    }

    public function set_update_time($value)
    {
        $this->update_time = $value;
    }
    public function set_cur_time()
    {
        $this->update_time = GetTime();
    }
    public function get_ip()
    {
        return $this->ip;
    }

    public function set_ip($value)
    {
        $this->ip = $value;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    private function GetUserIpAddr(){
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

}