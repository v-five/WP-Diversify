<?php

require_once('ismobile.php');

/******************************************************************
/* Build Player
******************************************************************/
class Player {
	
	var $width, $height;
	
	public function buildPlayer( $profileid = 1, $videoid = 1, $autodetect = 1 ) {
		global $wpdb;		
		
		$profile      = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."allvideogallery_profiles WHERE id=".$profileid);		
		$this->width  = $profile->width;
		$this->height = $profile->height;
		
		if( isset($_GET['slg']) && $autodetect == 1 ) {
			$slug    = $_GET['slg'];
			$video   = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."allvideogallery_videos WHERE slug='$slug'");
			$videoid = $video->id;
		} else {
			$video   = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."allvideogallery_videos WHERE  id=".$videoid);
		}	
	
		if($video->type == 'thirdparty') {
			$result    = '<div style="width:' . $this->width . 'px; height:' . $this->height . 'px;">';
			$result   .= $video->thirdparty;
			$result   .= '</div>';
		} else {		 	
	    	$flashvars = 'base='.get_option('siteurl').'&wp=1&vid='.$videoid.'&pid='.$profileid.'&page='.$this->curPageURL();
			$detect    = new IsMobile();			
	    	$result    = $detect->isMobile() ? $this->gethtmlplayer( $profile, $video ) : $this->getflashplayer( $profile, $flashvars );	
	 	}		
				
		$this->updatehits( $video->slug );
		
		$cust_class = ( $profile->custom_player_class ) ? $profile->custom_player_class : 'avs_player';
		
		$output  = '<style type="text/css">' . "\n";
		$output .= $profile->player_css . "\n";
		$output .= '</style>' . "\n";
		$output .= '<div class="'.$cust_class.'" style="width:'.$this->width.'px;">' . "\n";
		if($profile->title) {
			$output .= '<div class="title">'.$video->title.'</div>' . "\n";
		}
		if($profile->category) {
			$output .= '<div class="category"><strong>Category : </strong>'.$video->category.'</div>' . "\n";
		}
		if($profile->hits) {
			$output .= '<div class="hits"><strong>Hits : </strong>'.$video->hits.'</div>' . "\n";
		}
		$output .= '<div style="clear:both;"></div>' . "\n";
	 	$output .= $result . "\n";
		if($video->description) {
			$output .= '<div class="description">'.$video->description.'</div>' . "\n";
		}
		$output .= '</div>' . "\n";
		
		return $output;
	}

	public function getflashplayer( $profile, $flashvars ) {
		global $plugin_dir;
		
		$siteurl = get_option('siteurl');
		$src     = $siteurl . '/wp-content/plugins/' . $plugin_dir . '/player.swf?random=' . rand();
	
		$result  = '<object id="player" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" name="player" width="' . $this->width . '" height="' . $this->height . '">';
   		$result .= '<param name="movie" value="' . $src . '" />';
   		$result .= '<param name="wmode" value="opaque" />';
   		$result .= '<param name="allowfullscreen" value="true" />';
   		$result .= '<param name="allowscriptaccess" value="always" />';
   		$result .= '<param name="flashvars" value="' . $flashvars . '" />';
   		$result .= '<object type="application/x-shockwave-flash" data="' . $src . '" width="' . $this->width . '" height="' . $this->height . '">';
   		$result .= '<param name="movie" value="' . $src . '" />';
   		$result .= '<param name="wmode" value="opaque" />';
   		$result .= '<param name="allowfullscreen" value="true" />';
  		$result .= '<param name="allowscriptaccess" value="always" />';
   		$result .= '<param name="flashvars" value="' . $flashvars . '" />';
   		$result .= '</object>';
 		$result .= '</object>';
	 
		return $result;
	}

	public function gethtmlplayer( $profile, $video ) {
		if($video->type == 'youtube') {
    		$url_string = parse_url($video->video, PHP_URL_QUERY);
    		parse_str($url_string, $args);
    		$result  = '<iframe title="YouTube Video Player" width="'.$this->width.'" height="'.$this->height.'" ';
			$result .= 'src="http://www.youtube.com/embed/'.$args['v'].'" frameborder="0" allowfullscreen></iframe>';
		} else {
			$preview = $video->preview ? 'poster="' . $video->preview . '"' : '';
    		$result  = '<video onclick="this.play();" width="'.$this->width.'" height="'.$this->height.'" '.$preview.' controls>';
    		$result .= '<source src="'.$video->video.'" />';
			$result .= '</video>';
    	}
		 
		return $result;
	}
	
	function curPageURL() {
		$pageURL = 'http';
		if ($_SERVER["HTTPS"] == "on") { $pageURL .= "s"; }
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		
		return htmlspecialchars( $pageURL );
	}

	function updatehits( $slug ) {
    	global $wpdb;
		
		$table_name = $wpdb->prefix."allvideogallery_videos";
		$video = $wpdb->get_row("SELECT * FROM $table_name WHERE slug='$slug'");		
		$count = ($video) ? $video->hits + 1 : 1;
		$video->hits = $count;

		$wpdb->update($table_name, array('hits' => $video->hits), array('id' => $video->id));
	}

}

?>