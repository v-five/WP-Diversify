<?php

/******************************************************************
/* Created Tabular Menus
******************************************************************/
function allvideogallery_admin_tabs($current = 'profiles') {
	$tabs  = array('profiles' => 'All Video Gallery', 'categories' => 'Categories', 'videos' => 'Videos', 'docx' => 'Quickstart Guide');
	$links = array();
	
	foreach( $tabs as $tab => $name ) {
		if( $tab == $current) {
			$links[] = "<a class='nav-tab nav-tab-active' href='?page=allvideogallery_".$tab."'>$name</a>";
		} else {
			$links[] = "<a class='nav-tab' href='?page=allvideogallery_".$tab."'>$name</a>";
		}
	}
	
	echo '<div id="icon-upload" class="icon32"></div>';
	echo "<h2 class='nav-tab-wrapper'>";
	foreach( $links as $link ) {
		echo $link;
	}
	echo "</h2>";
	
}

?>