<?php

/******************************************************************
/* Build Player
******************************************************************/
class Widget {
	
	public function remove_qs_key($url, $key) {
		return preg_replace('/(?:&|(\?))' . $key . '=[^&]*(?(1)&|)?/i', "$1", $url);
	}

	public function buildGallery( $arr ) {
		global $wpdb;
		global $plugin_dir;	
		
		$query   = "SELECT * FROM ".$wpdb->prefix."allvideogallery_videos WHERE published=1";
		if( isset($_GET['slg']) ) {
			$slug   = $_GET['slg'];
			$query .= " AND slug!='$slug'";
		}
		
		if($arr['category']) {
			$gallery = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."allvideogallery_categories WHERE id=".$arr['category']);	
			$query  .= " AND category='$gallery->name'";
			$arr_params['catid'] = $gallery->slug;
		}
		
		$arr_params['sort'] = $arr['gallery'];
		switch($arr['gallery']) {
		 	case 'latest' :
		 		$query  .= ' ORDER BY id DESC';
				break;
			case 'popular' :
				$query  .= ' ORDER BY hits DESC';
				break;				
			case 'random' :
				$query  .= ' ORDER BY RAND()';
				break;
			case 'featured' :
				$query  .= ' AND featured=1 ORDER BY ordering';
				break;
			default :
				unset( $arr_params['sort'] );
				$query  .= ' ORDER BY ordering';
				break;
		 }
		
		$videos  = $wpdb->get_results($query); 	
			
		$custid     = ( $arr['custom_id'] ) ? $arr['custom_id']: 'avs_widget_gallery';
		$limit      = (int) $arr['count'];
		
		if(count($videos) < $limit) {
			$limit = count($videos);
			$arr['more'] = 0;
		}
		
		$output  = '<style type="text/css">';
		$output .= $arr['css'];
		$output .= '</style>';
		$output .= '<div id="' . $custid . '">';
		
  		for ($i=0, $n=$limit; $i < $n; $i++) {
			$arr_params['slg'] = $videos[$i]->slug;
			$output .= '<div class="avs_thumb">';
    		$output .= '<a href="' . @add_query_arg($arr_params, $arr['link']) . '">';
    		$output .= '<div class="left" style="width:' . $arr['thumb_width'] . 'px; height:' . $arr['thumb_height'] . 'px;">';
            $output .= '<img class="arrow" src="' . get_option('siteurl') . '/wp-content/plugins/' . $plugin_dir . '/assets/play.gif" style="margin-left:' . ($arr['thumb_width'] - 30) / 2 . 'px; margin-top:' . ($arr['thumb_height'] - 26) / 2 . 'px" border="0" />';
            $output .= '<img class="image" src="' . $videos[$i]->thumb . '" width="' . $arr['thumb_width'] . '" height="' . $arr['thumb_height'] . '" title="' . $videos[$i]->title . '" border="0" />';
            $output .= '</div>';
    		$output .= '<div class="right">';
            $output .= '<span class="title">' . $videos[$i]->title . '</span>';
            $output .= '<span class="hits"><strong>No. of Hits : </strong>' . $videos[$i]->hits . '</span>';
            $output .= '</div>';
    		$output .= '</a>';
			$output .= '</div>';
			$output .= '<div style="clear:both"></div>';
  	 	}
	 
  		if($arr['more'] == 1) {
			unset($arr_params['slg']);
  			$output .= '<div class="more"><a href="' . @add_query_arg($arr_params, $arr['link']) . '">more...</a></div>';
  		}
		
		$output .= '</div>';
		
		return $output;
	}
}

?>