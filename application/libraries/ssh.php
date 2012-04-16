<?php  if ( ! defined('APPPATH')) exit('No direct script access allowed');

class ssh {
	private $tipe = 'localhost'; //localhost | IP Address SSH
	private $user;
	private $pass;
	private $ssh;
	
	function __construct() {
		if ( ! defined('SSHDIR')) {
			define('SSHDIR',APPPATH.'/libraries/ssh/');
		}
	}

	public function setServer($srv,$user=false,$pass=false) {
		$this->tipe = $srv;
		$this->user = $user;
		$this->pass = $pass;	 	
	}
	
	public function setKey($key) {
		include_once(SSHDIR.'Crypt/RSA.php');
		$this->pass = new Crypt_RSA();
		$this->pass->loadKey($this->decode5t($key));
	}
	
	public function connect() {
		include_once(SSHDIR.'Net/SSH2.php');
	    $this->ssh = new Net_SSH2($this->tipe);
	    if (!$this->ssh->login($this->user, $this->pass)) {
    		return 'Login Failed / Server Down / SSH Server Down';
	    } 
		return true;
	}
	
	public function disconnect() {
		$this->ssh->disconnect();
		return true;
	}

	public function ex($cmd) {
		$output = $this->ssh->exec($cmd);
		return $output;
	}
	
	public function setflush() {
		if (ob_get_length()){           
		    @ob_flush();
		    @flush();
		    @ob_end_flush();
		}   
		@ob_start();
	}
	
	private function decode5t($str) {
	  for($i=0; $i<5;$i++) {
	    $str=base64_decode(strrev($str)); //apply base64 first and then reverse the string}
	  }
	  return $str;
	}
}

?>