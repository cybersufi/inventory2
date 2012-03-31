<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class extloader{

	private $CI;
	private $base_url;
	private $ext_url;
	private $extconfig;
	
	function extloader()
	{
		$this->CI =& get_instance();
		include(APPPATH.'config/ext.php');
		if (isset($ext)) {
			$this->extconfig = $ext;
		}
		$this->base_url = $this->CI->config->item('base_url');
		$this->ext_url = $this->extconfig['ext_url'];
	}
	
	function  loadbase() {
		$stylesheet = '<link href="'.$this->ext_url.'resources/css/ext-all.css" rel="stylesheet" type="text/css"/>';
		echo $stylesheet;
		$javascript = '<script type="text/javascript" src="'.$this->ext_url.'bootstrap.js"></script>';
		echo $javascript;
	}
	
	function stylesheet ( $asset_name = NULL, $media = NULL )
	{
		if ( $asset_name != NULL )
		{	
			//$asset_url = $this->asset_url . 'css/';
			$stylesheet = 	'<link href="' 	. 
							$this->ext_url		.
							$asset_name			.
							'.css" rel="stylesheet" type="text/css"';
	
			if ($media != NULL)
			{
				$stylesheet = $stylesheet . 	' media="' 	. 
												$media 		.
												'" />';
			}
			else
			{
				$stylesheet = $stylesheet . ' />';
			}
			
			echo $stylesheet;
		}
	}
	
	function javascript ( $asset_name = NULL )
	{
		if ( $asset_name != NULL )
		{
			//$asset_url = $this->asset_url . 'js/';
			$javascript = 	'<script type="text/javascript" src="'	. 
							$this->ext_url								.
							$asset_name								.
							'.js"></script>';
							
			echo $javascript;
		}
	}
	
	function image ( $asset_name = NULL, $alt = NULL, $additional_elements = NULL )
	{
		if ( $asset_name != NULL)
		{
			//$asset_url = $this->asset_url . 'images/';
			
			$image = 	'<img src="'	. 
						$this->ext_url		.
						$asset_name		.
						'"';
			
			if ( $alt != NULL )
			{
				$image =	$image		.
							' alt="'	.
							$alt		.
							'"';
			}
			
			if ( $additional_elements != NULL)
			{
				foreach ($additional_elements as $element=>$value)
				{
					$image = 	$image					.
								' ' 					.
								$element 				.
								'='						.
								'"'						.
								$value					.
								'"';
				}
			}

			$image = $image . ' />';
			
			echo $image;
		}
	}
}