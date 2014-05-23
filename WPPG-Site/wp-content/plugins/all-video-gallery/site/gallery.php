<?php

require_once('videos.php');
require_once('categories.php');

/******************************************************************
/* Build Player
******************************************************************/
class Gallery {
	
	public function buildGallery( $profileid = 1, $catid = 0, $sort = '' ) {
		global $wpdb;
		
		if( isset($_GET['catid']) ) {
		    $qid      = $_GET['catid'];			
		    $category = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."allvideogallery_categories WHERE slug='$qid'");
			$catid    = $category->id;
		}
		
		if( isset($_GET['sort']) ) {
		    $sort = $_GET['sort'];			
		}

		if($catid || $sort) {
			$gallery = new Videos();
			$output  = $gallery->buildGallery( $profileid, $catid, $sort );						
		} else {
			$gallery = new Categories();
			$output  = $gallery->buildGallery( $profileid );			
		}
		
		return $output;		
    }
	
} 
		 
?>