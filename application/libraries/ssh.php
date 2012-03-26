<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ssh {
	private $tipe = 'localhost'; //localhost | IP Address SSH
	private $user;
	private $pass;
	
	function ssh()
	{
		if ( ! defined('SSHDIR')) {
			define('SSHDIR',APPPATH.'/libraries/ssh/');
		}
	}

	function setServer($srv,$user=false,$pass=false)
	{
		$this->tipe = $srv;
		$this->user = $user;
		$this->pass = $pass;	 	
	}

	function ex($cmd)
	{
		if($this->tipe == 'localhost')
		{
			exec($cmd, $output);
			return $output;
		}
		else
		{
		    include_once(SSHDIR.'Net/SSH2.php');
		    $ssh = new Net_SSH2($this->tipe);
		    if (!$ssh->login($this->user, $this->pass)) 
			{
        		return 'Login Failed / Server Down / SSH Server Down';
		    }
			else
			{
			  	$output = $ssh->exec($cmd); 
			    $ssh->disconnect();
				return $output;
			}
		}
	}

	function setflush()
	{
		if (ob_get_length()){           
		    @ob_flush();
		    @flush();
		    @ob_end_flush();
		}   
		@ob_start();
	}
}
?>