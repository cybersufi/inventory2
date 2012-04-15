<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

abstract class device implements idevice {
    /**
     * load data from database and filled to system object
     *
     * @see ios::loadFromDatabase()
     *
     * @return void
     */
	public final function loadFromDatabase() {
		$CI =& get_instance();	
	}
	
	public final function saveToDatabase() {
		return null;
	}
	
	public final function toArray() {
		$array = get_object_vars($this);
	    unset($array['_parent'], $array['_index']);
	    array_walk_recursive($array, function(&$property, $key){
	        if(is_object($property)
	        && method_exists($property, 'toArray')){
	            $property = $property->toArray();
	        }
	    });
    	return $array;
	}
}
?>
