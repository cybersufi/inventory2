<?php if (!defined('APPPATH')) exit('No direct script access allowed');

class TT 
{

	private $id;
	private $assworkgroupname;
	private $assignepersonname;
	private $description;
	private $actualstart;
	private $deadline;
	private $priority;
	private $status;
	private $callername;
	private $classification;

	function __construct() {
		$this->id = 0;
		$this->assworkgroupname = '';
		$this->assignepersonname = '';
		$this->description = '';
		$this->actualstart = '';
		$this->deadline = '';
		$this->priority = '';
		$this->status = '';
		$this->callername = '';
		$this->classification = '';
	}

	public function getID()
	{
		return $this->id;
	}

	public function setID($value)
	{
		$this->id = $value;
	}

	public function getWorkgroupName()
	{
		return $this->assworkgroupname;
	}

	public function setWorkgroupName($value)
	{
		$this->assworkgroupname = $value;
	}

	public function getAssignePersonName()
	{
		return $this->assignepersonname;
	}

	public function setAssignePersonName($value)
	{
		$this->assignepersonname = $value;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function setDescription($value)
	{
		$this->description = $value;
	}

	public function getActualStart()
	{
		return $this->actualstart;
	}

	public function setActualStart($value)
	{
		$this->actualstart = $value;
	}

	public function getDeadline()
	{
		return $this->deadline;
	}

	public function setDeadline($value)
	{
		$this->deadline = $value;
	}

	public function getpriority()
	{
		return $this->priority;
	}

	public function setPriority($value)
	{
		$this->priority = $value;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function setStatus($value)
	{
		$this->status = $value;
	}

	public function getCallerName()
	{
		return $this->callername;
	}

	public function setCallerName($value)
	{
		$this->callername = $value;
	}

	public function getClassification()
	{
		return $this->classification;
	}

	public function setClassification($value)
	{
		$this->classification = $value;
	}

	public function toArray () 
	{
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