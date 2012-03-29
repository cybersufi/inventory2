<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

foreach ($links as $link) {
	echo '<h3>'.$link['text'].'</h3>';
	echo '<ul class="toggle">';
	foreach ($link['links'] as $sublink) {
		echo '<li class="'.$sublink['icon_cls'].'"><a href="'.$sublink['link'].'">'.$sublink['text'].'</a></li>';
	}
	echo '</ul>';
}

//<h3>Content</h3>
//<ul class="toggle">
//	<li class="icn_new_article"><a href="#">New Link</a></li>
//	<li class="icn_edit_article"><a href="#">Edit Link</a></li>
//	<li class="icn_categories"><a href="#">Show Links</a></li>
//</ul>

?>