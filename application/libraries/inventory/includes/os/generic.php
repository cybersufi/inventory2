<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

class generic extends os {
	public function build() {
		return null;
	}
	
	public function toArray(){
	    return $this->sys->toArray();
	}
}

?>
	