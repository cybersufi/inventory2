<?php if (!defined('APPPATH')) exit('No direct script access allowed');

class Link {
	private $id;
	private $linkname;
	private $linkalias;
	private $parent;
	private $childrens;

	function __construct($id=null, $linkname=null, $linkalias=null, $parent) {
		$this->id = $id;
		$this->linkname = $linkname;
		$this->linkalias = $linkalias;
		$this->parent = $parent;
		$this->childrens = new LinkCollection();
	}

	public function getId() {
		return $this->id;
	}

	public function setId($permId) {
		$this->id = $permId;
	}

	public function getLinkName()
	{
		return $this->linkname;
	}

	public function setLinkName($linkname)
	{
		$this->linkname = $linkname;
	}

	public function getLinkAlias()
	{
		return $this->linkalias;
	}

	public function setLinkAlias($alias)
	{
		$this->linkalias = $alias;
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