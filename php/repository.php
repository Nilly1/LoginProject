<?php
require_once 'functions.php';
require_once 'consts.php';
require_once 'user.php';

/*
* UsersRepository
* Singleton class for db manipulation.
*/
class UsersRepository
{
	protected static $instance = null;

	protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    /*
    * Instance()
    * returns an instance of the class.
    */
    public static function Instance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new UsersRepository();
            Debug("UsersRepository instance created");
        }
        return static::$instance;
    }

    /*
    * AddUser
    * Input: $user - holds user data to be saved in a file.
    * Note: File name is the username
    * 1. File name is the username
    * 2. This method is used only to create a temporary database.
    *    Therefore the assumption is that input is valid.
    */
    public function AddUser(User $user)
    {
    	if (!isset($user))
    	{
    		Debug("AddUser Error");
    		return;
    	}
    	$username = $user->get_username();
    	Debug("Start AddUser " . $username);
    	$file = '../' . DB_DIR . $username . FILE_TYPE;  
    	if(!file_exists($file))
    	{
    		$salt = GenerateRandomString();
    		$hashed_password = crypt($user->get_password(),$salt);
    		$user->set_password($hashed_password);
    		$user->set_salt($salt);
		    $contents = json_encode($user->jsonSerialize());
		    file_put_contents($file, $contents);
		    Debug("user " . $username . " is added");
		}
		else
		{
			Debug("user " . $username . " already exists");
		}
    }
    
    /*
    * GetUser
    * Read user's data from a given file
    */
    public function GetUser($file)
    {
    	Debug("GetUser " . $file);
    	$contents = '';
    	$file = '..' . DB_DIR . $file;

    	if(file_exists($file)){
		    $contents = file_get_contents($file);
		}
		return $contents;
    }

    /*
    * GetAllConnectedUsers
    * Return array with all the connected users
    */
    public function GetAllConnectedUsers(){ 
    	Debug("GetAllConnectedUsers started");
    	$arr = array();
    	try{
    		$dir = new DirectoryIterator('..' . DB_DIR);   
			foreach ($dir as $fileinfo) {
			    if (!$fileinfo->isDot()) {
			        $fname = $fileinfo->getFilename(); 
			        $user_content = $this->GetUser($fname);
			        $user_arr = json_decode($user_content,true);
			        if (isset($user_arr[PASS]) && ($this->IsConnected($user_arr[UPDATE_TIME])) === true){
			        	// For security reasons this sensitive information is not sent to the client
						unset($user_arr[PASS]);
						unset($user_arr[SALT]);
						$arr[] = $user_arr;
					}
			    }
			}
		}catch (Exception $e) {
			throw 'Caught exception: '.  $e->getMessage(). "\n";
		}
		return $arr;
    }

    /*
    * ChangeLastUpdateTime
    * Change last update time of a given user to current timestamp
    */
    public function ChangeLastUpdateTime($username){  
    	Debug("ChangeLastUpdateTime started");
    	$this->ChangeUserTimeProp(UPDATE_TIME,$username);    
    }

    /*
    * ChangeLastLoginTime
    * Change last login time of a given user to current timestamp
    */
    public function ChangeLastLoginTime($username){  
    	Debug("ChangeLastLoginTime started");
    	$this->ChangeUserTimeProp(LOGIN_TIME,$username);
    }

    /*
    * ChangeUserTimeProp
    * Update time in a user time property
    */
    public function ChangeUserTimeProp($prop,$username){  
    	Debug("ChangeUserTimeProp started");
    	$username = trim($username);
    	$user = $this->GetUser($username . FILE_TYPE);
    	$user_arr = json_decode($user,true);
    	$user_arr[$prop] = GetTime();     	
    	$file = '..' . DB_DIR . $username . FILE_TYPE;
    	if(file_exists($file)){
    		$contents = json_encode($user_arr);
		    file_put_contents($file, $contents);
		}
    }

    /*
    * IsConnected
    * Returns true if user sent update in the last TIME_INTERVAL seconds
    */
    public function IsConnected($update_time)
    {
    	Debug("IsConnected started");
    	return ((GetTimeInterval($update_time) > TIME_INTERVAL) ? false : true);
    }

    /*
    * IsUserExists
    * Returns true if user exists in db
    */
    public function IsUserExists($username){
    	Debug("IsUserExists started");
		$file = '..' . DB_DIR . $username . FILE_TYPE;

    	if(file_exists($file)){
    		return true;
    	}
    	return false;
    }

    /*
    * IsLoginOK
    * Returns true if password is correct
    */
    public function IsLoginOK($username,$pass)
    {
    	Debug("IsLoginOK started");
    	if ($this->IsUserExists($username) == true){
    		$user = $this->GetUser($username . FILE_TYPE);
    		$user_arr = json_decode($user,true);
    		$salt = $user_arr['salt'];
    		if ($user_arr[PASS] == crypt($pass,$salt))
    			return true;
    	}
    	return false;
    }
}

?>