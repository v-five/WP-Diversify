<?php

/******************************************************************
Plugin Name:All Video Gallery
Plugin URI:http://allvideogallery.mrvinoth.com
Description:Video Gallery extension for your Wordpress websites.
Version:1.0
Author:Vinoth Kumar
Author URI:http://mrvinoth.com
License:GPL2

Copyright 2011 All Video Gallery (email : admin@mrvinoth.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
******************************************************************/

require_once('installer.php');
require_once('uninstaller.php');
require_once('shortcode.php');
require_once('tabs.php');
require_once('widget.php');

global $plugin_dir;
$plugin_dir = basename(dirname(__FILE__));

/******************************************************************
/* Add Custom CSS file
******************************************************************/
function allvideogallery_plugin_css() {
	global $plugin_dir;
    $url = get_option('siteurl') . '/wp-content/plugins/' . $plugin_dir . '/allvideogallery.css';
    echo "<link rel='stylesheet' type='text/css' href='$url' />\n";
}

/******************************************************************
/* Creating Menus
******************************************************************/
function allvideogallery_plugin_menu() {
	global $plugin_dir;
    $icon = get_option('siteurl') . '/wp-content/plugins/' . $plugin_dir . '/assets/icon.png';
	add_menu_page("All Video Gallery Title", "All Video Gallery", "administrator", "allvideogallery_profiles", "allvideogallery_plugin_pages", $icon);
	add_submenu_page("allvideogallery_profiles", "All Video Gallery Categories", "Categories", "administrator", "allvideogallery_categories", "allvideogallery_plugin_pages");
	add_submenu_page("allvideogallery_profiles", "All Video Gallery Videos", "Videos", "administrator", "allvideogallery_videos", "allvideogallery_plugin_pages");
	add_submenu_page("allvideogallery_profiles", "All Video Gallery Quickstart Guide", "Quickstart Guide", "administrator", "allvideogallery_docx", "allvideogallery_plugin_pages");
}

/******************************************************************
/* Assigning Menu Pages
******************************************************************/
function allvideogallery_plugin_pages() {
    $itm = str_replace('allvideogallery_', '', $_GET["page"]);
	allvideogallery_admin_tabs($itm);	
	require_once ($itm . "/_default.php");
}

/******************************************************************
/* Implementing Hooks
******************************************************************/
if (is_admin()) {
	add_action('admin_head', 'allvideogallery_plugin_css');
  	add_action("admin_menu", "allvideogallery_plugin_menu");
	register_activation_hook(__FILE__,'allvideogallery_db_install');
	register_activation_hook(__FILE__,'allvideogallery_db_install_data');
	register_uninstall_hook(__FILE__, 'allvideogallery_db_uninstall');
}

?>