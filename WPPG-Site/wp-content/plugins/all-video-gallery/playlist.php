<?php

/**************************************************************************
/*Bootstrap file for getting the ABSPATH constant to wp-load.php
/*This is requried when a plugin requires access not via the admin screen.
**************************************************************************/
$path  = ''; 
if ( !defined('WP_LOAD_PATH') ) {
    $classic_root = dirname(dirname(dirname(dirname(__FILE__)))) . '/' ;
    if (file_exists( $classic_root . 'wp-load.php') ) {
    	define( 'WP_LOAD_PATH', $classic_root);
	} else if (file_exists( $path . 'wp-load.php') ) {
    	define( 'WP_LOAD_PATH', $path);
	} else {
    	exit("Could not find wp-load.php");
	}
}

require_once( WP_LOAD_PATH . 'wp-load.php');

/**************************************************************************
/*Write XML Output
**************************************************************************/
ob_clean();
header("content-type:text/xml;charset=utf-8");
echo '<?xml version="1.0" encoding="utf-8"?>'."\n";
echo '<playlist>'."\n";
echo buildNodes();
echo '</playlist>'."\n";
exit();

/**************************************************************************
/*Process XML Data
**************************************************************************/
function buildNodes() {
	global $wpdb;
	
	$video = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "allvideogallery_videos WHERE id=" . $_GET['vid']);
	$items = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "allvideogallery_videos WHERE category='" . $video->category . "' AND id!=" . $_GET['vid']);
	$node  = '';
	
	for ($i = 0, $n = count($items); $i < $n; $i++) {
		$item = $items[$i];
		
		$node .= '<item>'."\n";
		$node .= '<thumb>'.$item->thumb.'</thumb>'."\n";
		$node .= '<title>'.$item->title.'</title>'."\n";
		$node .= '<link>'.@add_query_arg( "slg", $item->slug, $_GET['page'] ).'</link>'."\n";
		$node .= '</item>'."\n";
	}
	
	return $node;
}

?>