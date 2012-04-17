<?php if ( ! defined('APPPATH')) exit('No direct script access allowed');

class parserhelper {
	
	public static function toKilo($value, $sizetype) {
		$sizetype = strtolower($sizetype);
		$res = 0;
		switch ($sizetype) {
			case 'm':
			case 'mb':
				$res = $value * 1024;
			break;
			case 'g':
			case 'gb':
				$res = $value * 1024 * 1024;
			default:
				$res = $value;
			break;
		}
		return $res;
	}
	
	public static function df($dfresult) {
		$res = array();
		$df = explode("\n", $dfresult);
		foreach ($df as $df_line) {
			$df_buf1 = preg_split("/(\%\s)/", $df_line, 2);
			if (count($df_buf1) != 2) {
			    continue;
			}
			if (preg_match("/(.*)(\s+)(([0-9]+)(\s+)([0-9]+)(\s+)([0-9]+)(\s+)([0-9]+)$)/", $df_buf1[0], $df_buf2)) {
				$df_buf = array($df_buf2[1], $df_buf2[4], $df_buf2[6], $df_buf2[8], $df_buf2[10], $df_buf1[1]);
				array_push($res, $df_buf);
			}
		}
		return $res;
	}
	
	public static function bdf($dfresult) {
		$res = array();
		$df = explode("\n", $dfresult);
		foreach ($df as $df_line) {
			$df_buf1 = preg_split("/(\%\s)/", $df_line, 2);
			if (count($df_buf1) == 1 ) {
			    continue;
			}
			if (preg_match("/(.*)(\s+)(([0-9]+)(\s+)([0-9]+)(\s+)([0-9]+)(\s+)([0-9]+)$)/", $df_buf1[0], $df_buf2)) {
				$df_buf = array($df_buf2[1], $df_buf2[4], $df_buf2[6], $df_buf2[8], $df_buf2[10], $df_buf1[1]);
				array_push($res, $df_buf);
			}
		}
		return $res;
	}
	
	public static function getUptime($uptime) {
		$uptime = str_replace(',','',$uptime);
		$uptime = preg_replace('~\s{2,}~', ' ', $uptime);
		$uptime2 = explode(' ', $uptime);
		$st = 0;
		if ( $uptime2[4] == "days" || $uptime2[4] == "min" ) {
			if ( $uptime2[4] == "days" ) {
		    	$dval = $uptime2[3] * 1440;
		    	if ( $uptime2[6] != "min") {
		   			$n = explode(':', $uptime2[5]);
		    		$st = (($n[0] * 60) + $n[1] + $dval) * 60;
		    	} else {
		    		$st = ($uptime2[5] + $dval) * 60; 
		    	}
			} else {
				$st = $uptime2[3] * 60;
			}
		} else {
			$n = explode(':', $uptime2[3]);
			$st = (($n[0] * 60) + $n[1]) * 60;
		}
		
		return $st;
	}
	
}

?>