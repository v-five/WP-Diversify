<?php

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

/******************************************************************
/* Install the DB Table
******************************************************************/
function allvideogallery_db_install() {
	global $wpdb;

	if(!get_site_option('allvideogallery_version')) {
   		$table_name = $wpdb->prefix . "allvideogallery_profiles";
		$sql = "CREATE TABLE " . $table_name . " (
  			`id` int(5) NOT NULL AUTO_INCREMENT,
  			`name` varchar(255) NOT NULL,
  			`width` int(5) NOT NULL,
  			`height` int(5) NOT NULL,
			`buffer` int(2) NOT NULL,
  			`volumelevel` int(2) NOT NULL,
			`stretch` varchar(10) NOT NULL,
  			`loop` tinyint(4) NOT NULL,
  			`autostart` tinyint(4) NOT NULL,  
			`title` tinyint(4) NOT NULL,
			`category` tinyint(4) NOT NULL, 
			`hits` tinyint(4) NOT NULL, 
			`controlbar` tinyint(4) NOT NULL,
			`playlist` tinyint(4) NOT NULL, 
  			`durationdock` tinyint(4) NOT NULL,
  			`timerdock` tinyint(4) NOT NULL,  
  			`fullscreendock` tinyint(4) NOT NULL,
  			`hddock` tinyint(4) NOT NULL,
  			`embeddock` tinyint(4) NOT NULL,
  			`facebookdock` tinyint(4) NOT NULL,
  			`twitterdock` tinyint(4) NOT NULL,
  			`controlbaroutlinecolor` varchar(10) NOT NULL,
  			`controlbarbgcolor` varchar(10) NOT NULL,
  			`controlbaroverlaycolor` varchar(10) NOT NULL,
  			`controlbaroverlayalpha` int(3) NOT NULL,
  			`iconcolor` varchar(10) NOT NULL,
  			`progressbarbgcolor` varchar(10) NOT NULL,
  			`progressbarbuffercolor` varchar(10) NOT NULL,
  			`progressbarseekcolor` varchar(10) NOT NULL,
  			`volumebarbgcolor` varchar(10) NOT NULL,
  			`volumebarseekcolor` varchar(10) NOT NULL,
			`playlistbgcolor` varchar(10) NOT NULL,
			`rows` int(2) NOT NULL,
  			`cols` int(2) NOT NULL,
			`thumb_width` int(5) NOT NULL,
  			`thumb_height` int(5) NOT NULL,
			`custom_player_class` varchar(100) NOT NULL,
			`player_css` text NOT NULL,
			`custom_gallery_id` varchar(100) NOT NULL,
			`gallery_css` text NOT NULL,
			UNIQUE KEY (`id`)
		);";
   		dbDelta($sql);
	
		$table_name = $wpdb->prefix . "allvideogallery_categories";
		$sql = "CREATE TABLE " . $table_name . " (
  			`id` int(5) NOT NULL AUTO_INCREMENT,
  			`name` varchar(255) NOT NULL,
  			`slug` varchar(255) NOT NULL,
  			`thumb` varchar(255) NOT NULL,
  			`published` tinyint(4) NOT NULL,
			UNIQUE KEY (`id`)
		);";
   		dbDelta($sql);
	
		$table_name = $wpdb->prefix . "allvideogallery_videos";
		$sql = "CREATE TABLE " . $table_name . " (
  			`id` int(5) NOT NULL AUTO_INCREMENT,
			`hits` int(5) NOT NULL,
  			`title` varchar(255) NOT NULL,
  			`slug` varchar(255) NOT NULL,
    	    `type` varchar(20) NOT NULL,  
			`streamer` varchar(255) NOT NULL,		
  			`video` varchar(255) NOT NULL,		
  			`hd` varchar(255) NOT NULL,
			`thirdparty` text NOT NULL, 
			`token` varchar(255) NOT NULL,		 
  			`thumb` varchar(255) NOT NULL,  
  			`preview` varchar(255) NOT NULL,
			`description` text NOT NULL,				
  			`category` varchar(255) NOT NULL,		
			`ordering` int(5) NOT NULL,
			`dvr` tinyint(4) NOT NULL,
  			`featured` tinyint(4) NOT NULL,  		
  			`published` tinyint(4) NOT NULL,
			UNIQUE KEY (`id`)
		);";
   		dbDelta($sql);	
	}
}

/******************************************************************
/* Add data to the installed DB Table
******************************************************************/
function allvideogallery_db_install_data() {
	global $wpdb;

	if(!get_site_option('allvideogallery_version')) {
		$table_name = $wpdb->prefix . "allvideogallery_profiles";	
		$wpdb->insert($table_name, array( 
			'id'                     => 1,
			'name'                   => "Default",
			'width'                  => 460, 
			'height'                 => 300,
			'buffer'                 => 3,
  			'volumelevel'            => 50,
  			'stretch'                => "uniform", 
			'loop'                   => 0,
  			'autostart'              => 0,
			'title'                  => 1,
			'category'               => 1,
			'hits'                   => 1,
			'controlbar'             => 1,
			'playlist'               => 0,
  			'durationdock'           => 1,
  			'timerdock'              => 1,  
  			'fullscreendock'         => 1,
  			'hddock'                 => 1,
  			'embeddock'              => 1,
  			'facebookdock'           => 1,
  			'twitterdock'            => 1,		
  			'controlbaroutlinecolor' => "0x292929",
  			'controlbarbgcolor'      => "0x111111",
  			'controlbaroverlaycolor' => "0x252525",
  			'controlbaroverlayalpha' => "35",
  			'iconcolor'              => "0xDDDDDD",
  			'progressbarbgcolor'     => "0x090909",
  			'progressbarbuffercolor' => "0x121212",
  			'progressbarseekcolor'   => "0x202020",
  			'volumebarbgcolor'       => "0x252525",
  			'volumebarseekcolor'     => "0x555555",
			'playlistbgcolor'        => "0x000000",
			'rows'                   => 3,
			'cols'                   => 3,
			'thumb_width'            => 145,
			'thumb_height'           => 80,
			'custom_player_class'    => "avs_player",
			'player_css'             => ".avs_player .title {\r\n	font-size:18px;\r\n	font-weight:bold;\r\n	margin:5px 0px;\r\n	line-height:14px;\r\n}\r\n.avs_player .category {\r\n	margin:3px 0px;\r\n	font-size:12px;\r\n	float:left;\r\n}\r\n.avs_player .hits {\r\n	margin:3px 0px;\r\n	font-size:12px;\r\n	float:right;\r\n}\r\n.avs_player .description {\r\n	margin:7px 0px;\r\n	padding:5px;\r\n	border:1px solid #E7E7E7;\r\n}",
			'custom_gallery_id'      => "avs_gallery",		
			'gallery_css'            => "#avs_gallery .avs_thumb {	\r\n	padding:0px;\r\n	margin:6px 12px 6px 0px;\r\n	line-height:18px;\r\n	float:left;\r\n}\r\n#avs_gallery a {\r\n	text-decoration:none;\r\n}\r\n#avs_gallery .avs_thumb .arrow {\r\n	position:absolute;\r\n	opacity:0.5;\r\n	filter:alpha(opacity=50);\r\n}\r\n#avs_gallery .avs_thumb .title {\r\n	display:block;\r\n	font-size:12px;\r\n	color:#444;\r\n}\r\n#avs_gallery .avs_thumb .hits {\r\n	display:block;\r\n	font-size:10px;\r\n	color:#777;\r\n}\r\n#avs_gallery .avs_thumb:hover {\r\n	opacity:0.85;\r\n	filter:alpha(opacity=85);\r\n}\r\nul.page-numbers {\r\n	margin: 10px 0 10px;\r\n	padding:0;\r\n	width:100%;\r\n	font-size: 12px;\r\n	clear: both;\r\n	float: left;\r\n	list-style:none;\r\n}\r\nul.page-numbers li {\r\n	float: left;\r\n}\r\nul.page-numbers a, ul.page-numbers span {\r\n	padding: 3px 6px;\r\n	margin: 2px;\r\n	text-decoration: none;\r\n	border: 1px solid #ccc;\r\n	color: #666;\r\n}\r\nul.page-numbers a:hover, ul.page-numbers span.current {\r\n	border: 1px solid #666;\r\n	color: #444;\r\n}"
		));
		add_option( "allvideogallery_version", "1.0" );
	}
}
    
?>