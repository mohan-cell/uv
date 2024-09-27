<?php 
class LoginUser{
	// class properties
	private $name;
	private $contact;
	public $error;
	public $success;
	private $storage = "acc.json";
	private $stored_users;

	// class methods
	public function __construct($name, $contact){
		$this->name = $name;
		$this->contact = $contact;
		$this->stored_users = json_decode(file_get_contents($this->storage), true);
		$this->login();
	}


	private function login(){
		foreach ($this->stored_users as $user) {
			if
			
($user['name'] == $this->name){
				if
				
($user['contact'] == $this->contact)
{
					
				
					session_start();
					$_SESSION['user'] = $this->name;
					header("location: indxe.php"); exit();
				}
			}
		}
		return $this->error = "Wrong username or password";
	}

}