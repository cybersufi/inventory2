<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

abstract class os implements ios {
    /**
     * @var System
     */
    protected $sys;
    
    /**
     * build the global Error object
     */
    public function __construct()
    {
        $this->sys = new system();
    }
    
    /**
     * get os specific encoding
     *
     * @see ios::getEncoding()
     *
     * @return string
     */
    public function getEncoding()
    {
        return null;
    }
    
    /**
     * get the filled or unfilled (with default values) System object
     *
     * @see ios::getSys()
     *
     * @return system
     */
    public final function getSys()
    {
        $this->build();
        return $this->sys;
    }
}
?>
