<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

foreach ($links as $link) {
	echo '<h3>'.$link['text'].'</h3>';
	echo '<ul class="toggle">';
	foreach ($link['links'] as $sublink) {
		$link = anchor($sublink['link'], $sublink['text'], '');
		echo '<li class="'.$sublink['icon_cls'].'">'.$link.'</li>';
	}
	echo '</ul>';
}

?>