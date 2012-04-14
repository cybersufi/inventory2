<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

abstract class parser implements iparser {
    
	protected $sys;
	protected $ssh;
	
	public function __construct() {
        $this->sys = new sys();
    }
	
    public final function getSys() {
    	$this->run();
    	return $this->sys;
    }
	
	public final function setSsh($ssh) {
		$this->ssh = $ssh;
	}
}
?>
