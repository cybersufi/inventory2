<?php if (!defined('APPPATH')) exit('No direct script access allowed');

class Menu {
	private $id;
	private $menuname;
	private $menualias;
	private $parent;
	private $childrens;

	function __construct($id=null, $menuname=null, $menualias=null, $parent) {
		$this->id = $id;
		$this->menuname = $menuname;
		$this->menualias = $menualias;
		$this->parent = $parent;
		$this->childrens = new MenuCollection();
	}

	public function getId() {
		return $this->id;
	}

	public function setId($permId) {
		$this->id = $permId;
	}

	public function getMenuName()
	{
		return $this->menuname;
	}

	public function setMenuName($menuname)
	{
		$this->menuname = $menuname;
	}

	public function getMenuAlias()
	{
		return $this->menualias;
	}

	public function setMenuAlias($alias)
	{
		$this->menualias = $alias;
	}

	public function getParent() {
		return $this->parent;
	}

	public function setParent($parent) {
		$this->parent = $parent;
	}

	public function getChildrens() {
		return $this->childrens;
	}

	public function setChildrens($childrens) {
		$this->childrens = $childrens;
	}

	public function toArray () {
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