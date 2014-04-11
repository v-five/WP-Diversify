<?php 
/* wppa-maintenance.php
* Package: wp-photo-album-plus
*
* Contains (not yet, but in the future maybe) all the maintenance routines
* Version 5.2.21
*
*/


// Main maintenace module
// Must return a string like: errormesssage||$slug||status||togo
function wppa_do_maintenance_proc( $slug ) {
global $wpdb;
global $album;
global $thumb;

	// Check for multiple maintenance procs
	$all_slugs = array( 'wppa_remake_index_albums', 
						'wppa_remove_empty_albums', 
						'wppa_remake_index_photos',
						'wppa_apply_new_photodesc_all',
						'wppa_append_to_photodesc',
						'wppa_remove_from_photodesc',
						'wppa_remove_file_extensions',
						'wppa_regen_thumbs',
						'wppa_rerate',
						'wppa_recup',
						'wppa_file_system',
						'wppa_cleanup',
						'wppa_remake',
						'wppa_list_index',
						'wppa_blacklist_user',
						'wppa_un_blacklist_user',
						'wppa_rating_clear',
						'wppa_viewcount_clear',
						'wppa_iptc_clear',
						'wppa_exif_clear'
					);
	foreach ( array_keys( $all_slugs ) as $key ) {
		if ( $all_slugs[$key] != $slug ) {
			if ( get_option( $all_slugs[$key].'_togo', '0') ) { 	// Process running
				return __('You can run only one maintenance procedure at a time', 'wppa').'||'.$slug.'||'.__('Error', 'wppa').'||'.''.'||'.'';
			}
		}
	}	

	// Lock this proc
	update_option( $slug.'_user', wppa_get_user() );
	
	// Initialize
	$endtime 	= time() + '5';	// Allow for 5 seconds
	$chunksize 	= '1000';
	$lastid 	= strval( intval ( get_option( $slug.'_last', '0' ) ) );
	$errtxt 	= '';
	$id 		= '0';
	$topid 		= '0';
	$reload 	= '';
	
	// Pre-processing needed?
	if ( $lastid == '0' ) {
		$_SESSION['wppa_session'][$slug.'_fixed'] = '0';
		$_SESSION['wppa_session'][$slug.'_deleted'] = '0';
		$_SESSION['wppa_session'][$slug.'_skipped'] = '0';
		switch ( $slug ) {
			case 'wppa_remake_index_albums':
				$wpdb->query( "UPDATE `".WPPA_INDEX."` SET `albums` = ''" );
				break;
			case 'wppa_remake_index_photos':
				$wpdb->query( "UPDATE `".WPPA_INDEX."` SET `photos` = ''" );
				wppa_index_compute_skips();
				break;
			case 'wppa_recup':
				$wpdb->query( "DELETE FROM `".WPPA_IPTC."` WHERE `photo` <> '0'" );
				$wpdb->query( "DELETE FROM `".WPPA_EXIF."` WHERE `photo` <> '0'" );
				break;
			case 'wppa_file_system':
				if ( get_option('wppa_file_system') == 'flat' ) update_option( 'wppa_file_system', 'to-tree' );
				if ( get_option('wppa_file_system') == 'tree' ) update_option( 'wppa_file_system', 'to-flat' );
				break;
		}
	}
	
	// Dispatch on albums / photos / single actions
	
	switch ( $slug ) {
	
		case 'wppa_remake_index_albums':
		case 'wppa_remove_empty_albums':

			// Process albums
			$table 		= WPPA_ALBUMS;
			$topid 		= $wpdb->get_var( "SELECT `id` FROM `".WPPA_ALBUMS."` ORDER BY `id` DESC LIMIT 1" );
			$albums 	= $wpdb->get_results( "SELECT * FROM `".WPPA_ALBUMS."` WHERE `id` > ".$lastid." ORDER BY `id` LIMIT 100", ARRAY_A );
			
			if ( $albums ) foreach ( $albums as $album ) {
			
				$id = $album['id'];
				
				switch ( $slug ) {
				
					case 'wppa_remake_index_albums':
						wppa_index_add( 'album' );
						break;
						
					case 'wppa_remove_empty_albums':
						$p = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM `".WPPA_PHOTOS."` WHERE `album` = %s", $id ) );
						$a = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM `".WPPA_ALBUMS."` WHERE `a_parent` = %s", $id ) );
						if ( ! $a && ! $p ) {
							$wpdb->query( $wpdb->prepare( "DELETE FROM `".WPPA_ALBUMS."` WHERE `id` = %s", $id ) );
							wppa_delete_album_source( $id );
							wppa_flush_treecounts( $id );
							wppa_index_remove( 'album', $id );
						}
						break;
						
				}
				// Test for timeout / ready
				$lastid = $id;
				update_option( $slug.'_last', $lastid );
				if ( time() > $endtime ) break; 	// Time out
			}
			else {	// Nothing to do, Done anyway
				$lastid = $topid;
			}
			break;	// End process albums
			
		case 'wppa_remake_index_photos':
			$chunksize = '100';
		case 'wppa_apply_new_photodesc_all':
		case 'wppa_append_to_photodesc':
		case 'wppa_remove_from_photodesc':
		case 'wppa_remove_file_extensions':
		case 'wppa_regen_thumbs':
		case 'wppa_rerate':
		case 'wppa_recup':
		case 'wppa_file_system':
		case 'wppa_cleanup':
		case 'wppa_remake':
		
			// Process photos
			$thumbsize 	= wppa_get_minisize();
			$table 		= WPPA_PHOTOS;
			$topid 		= $wpdb->get_var( "SELECT `id` FROM `".WPPA_PHOTOS."` ORDER BY `id` DESC LIMIT 1" );
			$photos 	= $wpdb->get_results( "SELECT * FROM `".WPPA_PHOTOS."` WHERE `id` > ".$lastid." ORDER BY `id` LIMIT ".$chunksize, ARRAY_A );
			
			if ( $photos ) foreach ( $photos as $photo ) {
				$thumb = $photo;	// Make globally known
				
				$id = $photo['id'];
				
				switch ( $slug ) {
				
					case 'wppa_remake_index_photos':
						wppa_index_add( 'photo' );
						break;
						
					case 'wppa_apply_new_photodesc_all':
						$value = get_option( 'wppa_newphoto_description' );
						$description = trim( $value );
						if ( $description != $photo['description'] ) {	// Modified photo description
							$wpdb->query( $wpdb->prepare( "UPDATE `".WPPA_PHOTOS."` SET `description` = %s WHERE `id` = %s", $description, $id ) );
						}
						break;
						
					case 'wppa_append_to_photodesc':
						$value = trim( get_option( 'wppa_append_text' ) );
						if ( ! $value ) return 'Unexpected error: missing text to append||'.$slug.'||Error||0';
						$description = rtrim( $photo['description'] . ' '. $value );
						if ( $description != $photo['description'] ) {	// Modified photo description
							$wpdb->query( $wpdb->prepare( "UPDATE `".WPPA_PHOTOS."` SET `description` = %s WHERE `id` = %s", $description, $id ) );
						}
						break;
						
					case 'wppa_remove_from_photodesc':
						$value = trim( get_option( 'wppa_remove_text' ) );
						if ( ! $value ) return 'Unexpected error: missing text to remove||'.$slug.'||Error||0';
						$description = rtrim( str_replace( $value, '', $photo['description'] ) );
						if ( $description != $photo['description'] ) {	// Modified photo description
							$wpdb->query( $wpdb->prepare( "UPDATE `".WPPA_PHOTOS."` SET `description` = %s WHERE `id` = %s", $description, $id ) );
						}
						break;
						
					case 'wppa_remove_file_extensions':
						$name = str_replace( array( '.jpg', '.png', 'gif', '.JPG', '.PNG', '.GIF' ), '', $photo['name'] );
						if ( $name != $photo['name'] ) {	// Modified photo name
							$wpdb->query( $wpdb->prepare( "UPDATE `".WPPA_PHOTOS."` SET `name` = %s WHERE `id` = %s", $name, $id ) );
						}
						break;
						
					case 'wppa_regen_thumbs':
						$path = wppa_get_photo_path( $id );
						if ( is_file( $path ) ) {
							wppa_create_thumbnail( $path, $thumbsize );
						}
						break;
						
					case 'wppa_rerate':
						$ratings = $wpdb->get_results( $wpdb->prepare( "SELECT `value` FROM `".WPPA_RATING."` WHERE `photo` = %s", $id ), ARRAY_A );
						$the_value = '0';
						$the_count = '0';
						if ( $ratings ) foreach ($ratings as $rating) {
							if ( $rating['value'] == '-1' ) $the_value += get_option( 'wppa_dislike_value' );
							else $the_value += $rating['value'];
							$the_count++;
						}
						if ( $the_count ) $the_value /= $the_count;
						if ( $the_value == '10' ) $the_value = '9.9999999';	// mean_rating is a text field. for sort order reasons we make 10 into 9.99999
						$wpdb->query( $wpdb->prepare( "UPDATE `".WPPA_PHOTOS."` SET `mean_rating` = %s WHERE `id` = %s", $the_value, $id ) );
						$ratcount = count($ratings);
						$wpdb->query( $wpdb->prepare( "UPDATE `".WPPA_PHOTOS."` SET `rating_count` = %s WHERE `id` = %s", $ratcount, $id ) );
						wppa_test_for_medal( $id );
						break;
						
					case 'wppa_recup':
						$a_ret = wppa_recuperate( $id );
						if ( $a_ret['iptcfix'] ) $_SESSION['wppa_session'][$slug.'_fixed']++;
						if ( $a_ret['exiffix'] ) $_SESSION['wppa_session'][$slug.'_fixed']++;
						break;
						
					case 'wppa_file_system':
						$fs = get_option( 'wppa_file_system', 'flat' );
						if ( $fs == 'to-tree' || $fs == 'to-flat' ) {
							if ( $fs == 'to-tree' ) {
								$from = 'flat';
								$to = 'tree';
							}
							else {
								$from = 'tree';
								$to = 'flat';
							}

							if ( file_exists( wppa_get_photo_path( $id, $from ) ) ) {
								@ rename ( wppa_get_photo_path( $id, $from ), wppa_get_photo_path( $id, $to ) );
							}
							if ( file_exists( wppa_get_thumb_path( $id, $from ) ) ) {
								@ rename ( wppa_get_thumb_path( $id, $from ), wppa_get_thumb_path( $id, $to ) );
							}
						}					
						break;
						
					case 'wppa_cleanup':
						$thumbpath = wppa_get_thumb_path( $id );
						$imagepath = wppa_get_photo_path( $id );
						if ( ! is_file( $imagepath ) ) {
							$wpdb->query( $wpdb->prepare( "DELETE FROM `".WPPA_PHOTOS."` WHERE `id` = %s", $id ) );
							if ( is_file( $thumbpath ) ) unlink( $thumbpath );
							$_SESSION['wppa_session'][$slug.'_deleted']++;
						}
						else {
							if ( ! is_file( $thumbpath ) ) {
								wppa_create_thumbnail( $imagepath, $thumbsize );
								$thumbpath = wppa_get_thumb_path( $id );
								if ( is_file( $thumbpath ) ) $_SESSION['wppa_session'][$slug.'_fixed']++;
							}
						}
						break;
						
					case 'wppa_remake':
						if ( wppa_remake_files( '', $id ) ) {
							$_SESSION['wppa_session'][$slug.'_fixed']++;
						}
						else {
							$_SESSION['wppa_session'][$slug.'_skipped']++;
						}
						break;
		
				}
				// Test for timeout / ready
				$lastid = $id;
				update_option( $slug.'_last', $lastid );
				if ( time() > $endtime ) break; 	// Time out
			}
			else {	// Nothing to do, Done anyway
				$lastid = $topid;
			}
			break;	// End process photos
			
		// Single action maintenance modules
		
//		case 'wppa_list_index':
//			break;
						
//		case 'wppa_blacklist_user':
//			break;
						
//		case 'wppa_un_blacklist_user':
//			break;
						
//		case 'wppa_rating_clear':
//			break;
						
//		case 'wppa_viewcount_clear':
//			break;
						
//		case 'wppa_iptc_clear':
//			break;
						
//		case 'wppa_exif_clear':
//			break;
			
		default:
			$errtxt = 'Unimplemented maintenance slug: '.strip_tags( $slug );
	}
	
	// either $albums / $photos has been exhousted ( for this try ) or time is up
//	$togo 	= $topid - $lastid;
	$togo 	= $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM `".$table."` WHERE `id` > %s ", $lastid ) );
	$status = $togo ? 'Pending' : 'Ready';
	if ( $togo ) {
		update_option( $slug.'_togo', $togo );
		update_option( $slug.'_status', $status );
	}
	else {	// Really done
	
		// Report fixed/skipped/deleted
		if ( ! isset( $_SESSION['wppa_session'] ) ) $_SESSION['wppa_session'] = array();
		if ( $_SESSION['wppa_session'][$slug.'_fixed'] ) $status .= ' '.$_SESSION['wppa_session'][$slug.'_fixed'].' fixed';
		if ( $_SESSION['wppa_session'][$slug.'_skipped'] ) $status .= ' '.$_SESSION['wppa_session'][$slug.'_skipped'].' skipped';
		if ( $_SESSION['wppa_session'][$slug.'_deleted'] ) $status .= ' '.$_SESSION['wppa_session'][$slug.'_deleted'].' deleted';
		
		// Re-Init options
		delete_option( $slug.'_togo', '' );
		delete_option( $slug.'_status', '' );
		delete_option( $slug.'_last', '0' );
		delete_option( $slug.'_user', '' );
		
		// Post-processing needed?
		switch ( $slug ) {
			case 'wppa_remake_index_albums':
			case 'wppa_remake_index_photos':
				$wpdb->query( "DELETE FROM `".WPPA_INDEX."` WHERE `albums` = '' AND `photos` = ''" );	// Remove empty entries
				break;
			case 'wppa_apply_new_photodesc_all':
			case 'wppa_append_to_photodesc':
			case 'wppa_remove_from_photodesc':
				update_option( 'wppa_remake_index_photos_status', __('Required', 'wppa') ); 
				break;
			case 'wppa_regen_thumbs':
				wppa_bump_thumb_rev();
				break;
			case 'wppa_file_system':
				wppa_update_option( 'wppa_file_system', $to );
				$reload = 'reload';
				break;
			case 'wppa_remake':
				wppa_bump_photo_rev();
				wppa_bump_thumb_rev();
				break;
		}
	}

	return $errtxt.'||'.$slug.'||'.$status.'||'.$togo.'||'.$reload;
}

function wppa_do_maintenance_popup( $slug ) {
global $wpdb;
global $thumb;

	$result = '';
	
	switch ( $slug ) {
		case 'wppa_list_index':
			$start = get_option( 'wppa_list_index_display_start', '' );
			$total = $wpdb->get_var( "SELECT COUNT(*) FROM `".WPPA_INDEX."`" );
			$indexes = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `".WPPA_INDEX."` WHERE `slug` >= %s ORDER BY `slug` LIMIT 1000", $start ), ARRAY_A );

			$result .= '
			<style>td, th { border-right: 1px solid darkgray; } </style>
			<h2>List of Searcheable words <small>( Max 1000 entries of total '.$total.' )</small></h2>
			<div style="float:left; clear:both; width:100%; height:450px; overflow:auto; background-color:#f1f1f1; border:1px solid #ddd;" >';
			if ( $indexes ) {
				$result .= '
				<table>
					<thead>
						<tr>
							<th><span style="float:left;" >Word</span></th>
							<th style="max-width:400px;" ><span style="float:left;" >Albums</span></th>
							<th><span style="float:left;" >Photos</span></th>
						</tr>
						<tr><td colspan="3"><hr /></td></tr>
					</thead>
					<tbody>';
						
				foreach ( $indexes as $index ) {
					$result .= '
						<tr>
							<td>'.$index['slug'].'</td>
							<td style="max-width:400px; word-wrap: break-word;" >'.$index['albums'].'</td>
							<td>'.$index['photos'].'</td>
						</tr>';
				}
		
				$result .= '
					</tbody>
				</table>';
			}
			else {
				$result .= __('There are no index items.', 'wppa');
			}
			$result .= '
				</div><div style="clear:both;"></div>';

			break;
			
		case 'wppa_list_errorlog':
			$filename = ABSPATH.'wp-content/wppa-depot/admin/error.log';
			$result .= '
				<h2>List of WPPA+ error messages <small>( Newest first )</small></h2>
				<div style="float:left; clear:both; width:100%; height:450px; overflow:auto; word-wrap:none; background-color:#f1f1f1; border:1px solid #ddd;" >';

			if ( ! $file = @ fopen( $filename, 'r' ) ) {
				$result .= __('There are no error log messages', 'wppa');
			}
			else {
				$size = filesize( $filename );
				$data = fread( $file, $size );
				$messages = explode( "\n", $data );
				$count = count( $messages );
				$idx = $count - '2';
				while ( $idx >= '0' ) {
					$result .= $messages[$idx].'<br />';
					$idx--;
				}
			}
			
			$result .= '
				</div><div style="clear:both;"></div>
				';
			break;

		case 'wppa_list_rating':
			$total = $wpdb->get_var( "SELECT COUNT(*) FROM `".WPPA_RATING."`" );
			$ratings = $wpdb->get_results( "SELECT * FROM `".WPPA_RATING."` ORDER BY `timestamp` DESC LIMIT 1000", ARRAY_A );
			$result .= '
			<style>td, th { border-right: 1px solid darkgray; } </style>
			<h2>List of recent ratings <small>( Max 1000 entries of total '.$total.' )</small></h2>
			<div style="float:left; clear:both; width:100%; height:450px; overflow:auto; background-color:#f1f1f1; border:1px solid #ddd;" >';
			if ( $ratings ) {
				$result .= '
				<table>
					<thead>
						<tr>
							<th>Id</th>
							<th>Timestamp</th>
							<th>Date/time</th>
							<th>User</th>
							<th>Value</th>
							<th>Photo id</th>
							<th></th>
							<th># ratings</th>
							<th>Average</th>
						</tr>
						<tr><td colspan="9"><hr /></td></tr>
					</thead>
					<tbody>';
								
				foreach ( $ratings as $rating ) {
					wppa_cache_thumb($rating['photo']);
					$result .= '
						<tr>
							<td>'.$rating['id'].'</td>
							<td>'.$rating['timestamp'].'</td>
							<td>'.( $rating['timestamp'] ? wppa_local_date(get_option('date_format', "F j, Y,").' '.get_option('time_format', "g:i a"), $rating['timestamp']) : 'pre-historic' ).'</td>
							<td>'.$rating['user'].'</td>
							<td>'.$rating['value'].'</td>
							<td>'.$rating['photo'].'</td>
							<td style="width:250px; text-align:center;"><img src="'.wppa_get_thumb_url($rating['photo']).'" 
								style="height: 40px;" 
								onmouseover="jQuery(this).stop().animate({height:this.naturalHeight}, 200);"
								onmouseout="jQuery(this).stop().animate({height:\'40px\'}, 200);" /></td>
							<td>'.$thumb['rating_count'].'</td>
							<td>'.$thumb['mean_rating'].'</td>
						</tr>';
				}
				
				$result .= '
					</tbody>
				</table>';
			}
			else {
				$result .= __('There are no ratings', 'wppa');
			}
			$result .= '
				</div><div style="clear:both;"></div>';

			break;
			
		default:
			$result = 'Error: Unimplemented slug: '.$slug.' in wppa_do_maintenance_popup()';
	}
	
	return $result;
}

function wppa_recuperate( $id ) {
global $thumb;
global $wpdb;
	
	wppa_cache_thumb( $id );
	$iptcfix = false;
	$exiffix = false;
	$file = wppa_get_source_path( $id );
	if ( ! is_file( $file ) ) $file = wppa_get_photo_path( $id );

	if ( is_file ( $file ) ) {					// Not a dir
		$attr = getimagesize( $file, $info );
		if ( is_array( $attr ) ) {				// Is a picturefile
			if ( $attr[2] == IMAGETYPE_JPEG ) {	// Is a jpg

				if ( wppa_switch( 'wppa_save_iptc' ) ) {	// Save iptc
					if ( isset( $info["APP13"] ) ) {		// There is IPTC data
						$is_iptc = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM `".WPPA_IPTC."` WHERE `photo` = %s", $id ) );
						if ( ! $is_iptc ) { 				// No IPTC yet and there is: Recuperate
							wppa_import_iptc($id, $info, 'nodelete');
							$iptcfix = true;
						}						
					}
				}
				
				if ( wppa_switch('wppa_save_exif') ) {		// Save exif
					$image_type = exif_imagetype( $file );
					if ( $image_type == IMAGETYPE_JPEG ) {	// EXIF supported by server
						$is_exif = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM `".WPPA_EXIF."` WHERE `photo`=%s", $id ) );
						if ( ! $is_exif ) { 				// No EXIF yet
							$exif = @ exif_read_data($file, 'EXIF');//@
							if ( is_array( $exif ) ) { 		// There is exif data present
								wppa_import_exif($id, $file, 'nodelete');
								$exiffix = true;
							}
						}						
					}	
				}				
			}					
		}
	}
	return array( 'iptcfix' => $iptcfix, 'exiffix' => $exiffix );
}
				
// Fix erroneous source path in case of migration to an other host
function wppa_fix_source_path() {
global $wppa_opt;

	if ( is_writable( $wppa_opt['wppa_source_dir'] ) ) return; 					// Nothing to do here
	
	// The source path should be: ( default ) ABSPATH.WPPA_UPLOAD.'/wppa-source',
	// Or at least below ABSPATH
	if ( strpos( $wppa_opt['wppa_source_dir'], ABSPATH ) === false ) {
		if ( strpos( $wppa_opt['wppa_source_dir'], 'wp-content' ) !== false ) {	// Its below wp-content
			$temp = explode( 'wp-content', $wppa_opt['wppa_source_dir'] );
			$temp['0'] = ABSPATH;
			$wppa_opt['wppa_source_dir'] = implode( 'wp-content', $temp );
			wppa_update_option( 'wppa_source_dir', $wppa_opt['wppa_source_dir'] );
			wppa_update_message( 'Sourcepath set to '.$wppa_opt['wppa_source_dir'] );
		}
		else { // Give up, set to default
			$wppa_opt['wppa_source_dir'] = ABSPATH.WPPA_UPLOAD.'/wppa-source';
			wppa_update_option( 'wppa_source_dir', $wppa_opt['wppa_source_dir'] );
			wppa_update_message( 'Sourcepath set to default.' );
		}
	}
}
