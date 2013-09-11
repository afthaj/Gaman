<?php
require_once("database.php");

class Session {
	
	private $logged_in = false;
	public $id;
	public $object_type;
	public $message;
	
	function __construct(){
		session_start();
		$this->check_message();
		$this->check_log_in();
		if ($this->logged_in){
			
		}
	}
	
	public function is_logged_in(){
		return $this->logged_in;
	}
	
	public function login($user, $object_type){
		
		if ($user){
			$this->object_type = $_SESSION['object_type'] = $object_type;
			// object_type = 5 is admin, 4 is bus_personnel, 6 is commuter 
			/* if ($object_type == 5 ){
				$this->admin_id = $_SESSION['id'] = $user->id;
			} else if ($object_type == 4 ){
				$this->bus_personnel_id = $_SESSION['id'] = $user->id;
			} else if ($object_type == 6 ){
				$this->commuter_id = $_SESSION['id'] = $user->id;
			} */
			$this->id = $_SESSION['id'] = $user->id;
			$this->logged_in = true;
		}
	}
	
	public function logout(){
		unset($_SESSION['id']);
		unset($_SESSION['object_type']);
		$this->object_type = "";
		$this->logged_in = false;
	}
	
	private function check_log_in(){
		if (isset($_SESSION['id']) && isset($_SESSION['object_type'])){
			$this->id = $_SESSION['id'];
			$this->object_type = $_SESSION['object_type'];
			$this->logged_in = true;
		} else {
			unset($this->id);
			unset($this->object_type);
			$this->logged_in = false;
		}
	}
	
	private function check_message(){
		if (isset($_SESSION['message'])){
			$this->message = $_SESSION['message'];
			unset($_SESSION['message']);
		} else {
			$this->message = "";
		}
	}
	
	public function message($msg=""){
		if(!empty($msg)){
			$_SESSION['message'] = $msg;
		} else {
			return $this->message;
		}
	}
	
}

$session = new Session();
$message = $session->message();

?>