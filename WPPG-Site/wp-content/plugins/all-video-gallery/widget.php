<?php

require_once('site/widget.php');

class AllVideoGallery_Widget extends WP_Widget {

/*****************************************************************/
/* Widget Setup
******************************************************************/
function AllVideoGallery_Widget() {
	$widget_ops  = array( 'classname' => 'allvideogallery', 'description' => __('Use this widget to add All Video Gallery to your site\'s sidebar.', 'allvideogallery') );
	$control_ops = array( 'width' => 290, 'height' => 350, 'id_base' => 'allvideogallery' );
	$this->WP_Widget( 'allvideogallery', 'All Video Gallery', $widget_ops, $control_ops );
}

/*****************************************************************/
/* How to display the widget on the screen
******************************************************************/
function widget( $args, $instance ) {
	extract( $args );

	$title = apply_filters('widget_title', $instance['title'] );

	echo $before_widget;

	if ( $title ) echo $before_title . $title . $after_title;

	$gallery = new Widget();
    echo $gallery->buildGallery( $instance );

	echo $after_widget;
}

/*****************************************************************/
/* Update the widget settings
******************************************************************/
function update( $new_instance, $old_instance ) {
	$instance = $old_instance;

	$instance['title']        = strip_tags( $new_instance['title'] );
	$instance['thumb_width']  = $new_instance['thumb_width']; 
	$instance['thumb_height'] = $new_instance['thumb_height'];
	$instance['count']        = $new_instance['count'];  
	$instance['custom_id']    = $new_instance['custom_id']; 
	$instance['css']          = $new_instance['css'];
	$instance['category']     = strip_tags( $new_instance['category'] ); 
	$instance['gallery']      = $new_instance['gallery']; 
	$instance['link']         = $new_instance['link'];
	$instance['more']         = ( isset( $new_instance['more'] ) ? 1 : 0 );   
	
	return $instance;
}

/*****************************************************************/
/* Displays the widget settings controls on the widget panel
******************************************************************/
function form( $instance ) {
	$defaults = array( 
		'title'        => '', 
		'thumb_width'  => 75,
		'thumb_height' => 50,
		'count'        => 4,	
		'custom_id'    => 'avs_widget_gallery',
		'css'          => "#avs_widget_gallery .avs_thumb {\r\n	border-bottom:1px solid #E7E7E7;\r\n	margin:0px;\r\n	padding:7px;\r\n	float:left;\r\n	width:99%;\r\n}\r\n#avs_widget_gallery a {\r\n	text-decoration:none;\r\n}\r\n#avs_widget_gallery .avs_thumb:hover {\r\n	background-color:#F1F1F1;\r\n}\r\n#avs_widget_gallery .avs_thumb .left {\r\n	float:left;\r\n}\r\n#avs_widget_gallery .avs_thumb .right {\r\n	width:100px;\r\n	margin-left:5px;\r\n	float:left;\r\n}\r\n#avs_widget_gallery .avs_thumb .arrow {\r\n	position:absolute;\r\n	opacity:0.5;\r\n	filter:alpha(opacity=50);\r\n}\r\n#avs_widget_gallery .avs_thumb .title {\r\n	display:block;\r\n	font-size:12px;\r\n	color:#444;\r\n}\r\n#avs_widget_gallery .avs_thumb .hits {\r\n	display:block;\r\n	font-size:10px;\r\n	color:#777;\r\n}\r\n#avs_widget_gallery .more {\r\n	border-bottom:1px solid #E7E7E7;	\r\n	padding:7px;\r\n	width:99%;\r\n	text-align:center;\r\n}\r\n#avs_widget_gallery .more a {\r\n	width:32px;\r\n}",
		'category'     => '', 
		'gallery'      => 'latest', 
		'link'         => '',
		'more'         => 1	
	);
	$instance = wp_parse_args( (array) $instance, $defaults ); 	
?>

<p>
  <label for="<?php echo $this->get_field_id( 'title' ); ?>">
  <?php _e('Title :'); ?>
  </label>
  <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>"  />
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'thumb_width' ); ?>">
  <?php _e('Thumbnail Width :'); ?>
  </label>
  <input class="widefat" id="<?php echo $this->get_field_id('thumb_width'); ?>" name="<?php echo $this->get_field_name('thumb_width'); ?>" value="<?php echo $instance['thumb_width']; ?>"  />
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'thumb_height' ); ?>">
  <?php _e('Thumbnail Height :'); ?>
  </label>
  <input class="widefat" id="<?php echo $this->get_field_id('thumb_height'); ?>" name="<?php echo $this->get_field_name('thumb_height'); ?>" value="<?php echo $instance['thumb_height']; ?>"  />
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'count' ); ?>">
  <?php _e('Display Count :'); ?>
  </label>
  <input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" value="<?php echo $instance['count']; ?>"  />
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'custom_id' ); ?>">
  <?php _e('Custom ID for the Gallery DIV :'); ?>
  </label>
  <input class="widefat" id="<?php echo $this->get_field_id('custom_id'); ?>" name="<?php echo $this->get_field_name('custom_id'); ?>" value="<?php echo $instance['custom_id']; ?>"  />
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'css' ); ?>">
  <?php _e('Style the Gallery :'); ?>
  </label>
  <textarea class="widefat" id="<?php echo $this->get_field_id('css'); ?>" name="<?php echo $this->get_field_name('css'); ?>" rows="7"><?php echo $instance['css']; ?></textarea>
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'link' ); ?>">
  <?php _e('Custom Page URL :'); ?>
  </label>
  <input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" value="<?php echo $instance['link']; ?>"  />
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'category' ); ?>">
  <?php _e('Category ID : [optional]'); ?>
  </label>
  <input class="widefat" id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>" value="<?php echo $instance['category']; ?>"  />
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'gallery' ); ?>">
  <?php _e('Gallery Type :'); ?>
  </label>
  <select id="<?php echo $this->get_field_id( 'gallery' ); ?>" name="<?php echo $this->get_field_name( 'gallery' ); ?>">
    <option value="default" id="default" <?php if ( 'default' == $instance['gallery'] ) echo 'selected="selected"'; ?>><?php _e('Default'); ?></option>
    <option value="latest" id="latest" <?php if ( 'latest' == $instance['gallery'] ) echo 'selected="selected"'; ?>><?php _e('Latest Videos'); ?></option>
    <option value="popular" id="popular" <?php if ( 'popular' == $instance['gallery'] ) echo 'selected="selected"'; ?>><?php _e('Popular Videos'); ?></option>
    <option value="featured" id="featured" <?php if ( 'featured' == $instance['gallery'] ) echo 'selected="selected"'; ?>><?php _e('Featured Videos'); ?></option>
    <option value="random" id="random" <?php if ( 'random' == $instance['gallery'] ) echo 'selected="selected"'; ?>><?php _e('Random Videos'); ?></option>
  </select>
</p>
<p>
  <input class="checkbox" type="checkbox" <?php checked( $instance['more'], true ); ?> id="<?php echo $this->get_field_id('more'); ?>" name="<?php echo $this->get_field_name('more'); ?>" />
  <label for="<?php echo $this->get_field_id( 'more' ); ?>">
  <?php _e('More Button'); ?>
  </label>
</p>
<?php } }

/*****************************************************************/
/* Register our Widget
******************************************************************/
function allvideogallery_load_widgets() {
	register_widget( 'AllVideoGallery_Widget' );
}

add_action( 'widgets_init', 'allvideogallery_load_widgets' );

?>