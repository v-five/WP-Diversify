<?php

require_once('site/player.php');
require_once('site/gallery.php');

/******************************************************************
/* User Function
******************************************************************/
function allvideogallery_plugin_shortcode( $atts ) {
	 $profileid  = $atts['profile'];
	 $videoid    = $atts['video'];
	 $catid      = $atts['category'];
	 $sort       = $atts['sort'];
	 $autodetect = ( $atts['autodetect'] == '' ) ? 1 : $atts['autodetect'];
	 $output     = '';
	 
	 if($videoid) {
	 	$player = new Player();
	 	$output = $player->buildPlayer( $profileid, $videoid, $autodetect );
	 } else {
	 	if(isset($_GET['slg'])) {
	 		$player  = new Player();	
	 		$output .= $player->buildPlayer( $profileid, $videoid, $autodetect );
	 	}	 
	 	$gallery = new Gallery();
		$output .= $gallery->buildGallery( $profileid, $catid, $sort);
	 }
	
	 return $output;
}

add_shortcode('allvideogallery', 'allvideogallery_plugin_shortcode');

?>