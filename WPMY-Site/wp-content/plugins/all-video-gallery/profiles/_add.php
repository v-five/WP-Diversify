<?php

/******************************************************************
/* Inserting (or) Updating the DB Table when edited
******************************************************************/
if($_POST['edited'] == 'true' && check_admin_referer( 'allvideogallery-nonce')) {
	unset($_POST['group'], $_POST['edited'], $_POST['_wpnonce'], $_POST['_wp_http_referer']);
	$wpdb->insert($table_name, $_POST);
	echo '<script>window.location="?page=allvideogallery_profiles";</script>';
}

/******************************************************************
/* Getting Input from the DB Table
******************************************************************/
$data = $wpdb->get_row("SELECT * FROM $table_name WHERE id=1");
	
?>

<div class="wrap">
  <form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>" onsubmit="return allvideogallery_validate();">
    <?php wp_nonce_field('allvideogallery-nonce'); ?>
    <?php  echo "<h3>" . __( 'General Player Settings' ) . "</h3>"; ?>
    <table cellpadding="0" cellspacing="10">
      <tr>
        <td width="170"><?php _e("Profile Name"); ?></td>
        <td><input type="text" id="name" name="name" value="<?php echo $data->name; ?>" size="50"></td>
      </tr>
      <tr>
        <td><?php _e("Player Width"); ?></td>
        <td><input type="text" id="width" name="width" value="<?php echo $data->width; ?>" size="50"></td>
      </tr>
      <tr>
        <td><?php _e("Player Height"); ?></td>
        <td><input type="text" id="height" name="height" value="<?php echo $data->height; ?>" size="50"></td>
      </tr>
      <tr>
        <td><?php _e("Buffer Time"); ?></td>
        <td><input type="text" id="buffer" name="buffer" value="<?php echo $data->buffer; ?>" size="50"></td>
      </tr>
      <tr>
        <td><?php _e("Volume Level"); ?></td>
        <td><input type="text" id="volumelevel" name="volumelevel" value="<?php echo $data->volumelevel; ?>" size="50"></td>
      </tr>
      <tr>
        <td><?php _e("Stretch Type"); ?></td>
        <td>
        	<select id="stretch" name="stretch">
            	<option value="fill" id="fill"><?php _e("Fill"); ?></option>
            	<option value="uniform" id="uniform"><?php _e("Uniform"); ?></option>
            	<option value="none" id="none"><?php _e("Original"); ?></option>
            	<option value="exactfit" id="exactfit"><?php _e("Exact Fit"); ?></option>
          	</select>
          	<?php echo '<script>document.getElementById("'.$data->stretch.'").selected="selected"</script>'; ?> </td>
      </tr>
      <tr>
        <td><?php _e("Loop"); ?></td>
        <td>
        	<input type="hidden" name="loop" value="">
          	<input type="checkbox" id="loop" name="loop" value="1" <?php if($data->loop == 1){echo 'checked="checked" ';}?>>
        </td>
      </tr>
      <tr>
        <td><?php _e("AutoStart"); ?></td>
        <td>
        	<input type="hidden" name="autostart" value="">
          	<input type="checkbox" id="autostart" name="autostart" value="1" <?php if($data->autostart == 1){echo 'checked="checked" ';}?>>
        </td>
      </tr>
      <tr>
        <td><?php _e("Show Video Title"); ?></td>
        <td>
        	<input type="hidden" name="title" value="">
          	<input type="checkbox" id="title" name="title" value="1" <?php if($data->title == 1){echo 'checked="checked" ';}?>>
        </td>
      </tr>
      <tr>
        <td><?php _e("Show Category Name"); ?></td>
        <td>
        	<input type="hidden" name="category" value="">
          	<input type="checkbox" id="category" name="category" value="1" <?php if($data->category == 1){echo 'checked="checked" ';}?>>
        </td>
      </tr>
      <tr>
        <td><?php _e("Show Hits"); ?></td>
        <td>
        	<input type="hidden" name="hits" value="">
          	<input type="checkbox" id="hits" name="hits" value="1" <?php if($data->hits == 1){echo 'checked="checked" ';}?>>
        </td>
      </tr>
    </table>
    <?php  echo "<h3>" . __( 'Enable [or] Disable Skin Elements' ) . "</h3>"; ?>
    <table cellpadding="0" cellspacing="10">
      <tr>
      	<td>
        	<input type="hidden" name="controlbar" value="">
          	<input type="checkbox" id="controlbar" name="controlbar" value="1" <?php if($data->controlbar == 1){echo 'checked="checked" ';}?>>
        </td>
        <td><?php _e("ControlBar"); ?></td>
        <td>
        	<input type="hidden" name="playlist" value="">
          	<input type="checkbox" id="playlist" name="playlist" value="1" <?php if($data->playlist == 1){echo 'checked="checked" ';}?>>
        </td>
        <td><?php _e("PlayList Dock"); ?></td>
        <td>
        	<input type="hidden" name="durationdock" value="">
          	<input type="checkbox" id="durationdock" name="durationdock" value="1" <?php if($data->durationdock == 1){echo 'checked="checked" ';}?>>
        </td>
        <td><?php _e("Duration Dock"); ?></td>
        <td>
        	<input type="hidden" name="timerdock" value="">
          	<input type="checkbox" id="timerdock" name="timerdock" value="1" <?php if($data->timerdock == 1){echo 'checked="checked" ';}?>>
        </td>
        <td><?php _e("Timer Dock"); ?></td>
        <td>
        	<input type="hidden" name="fullscreendock" value="">
          	<input type="checkbox" id="fullscreendock" name="fullscreendock" value="1" <?php if($data->fullscreendock == 1){echo 'checked="checked" ';}?>></td>
        <td><?php _e("Fullscreen Dock"); ?></td>        
      </tr>
      <tr>
      	<td>
        	<input type="hidden" name="hddock" value="">
          	<input type="checkbox" id="hddock" name="hddock" value="1" <?php if($data->hddock == 1){echo 'checked="checked" ';}?>>
        </td>
        <td><?php _e("HD Dock" ); ?></td>
        <td>
        	<input type="hidden" name="embeddock" value="">
          	<input type="checkbox" id="embeddock" name="embeddock" value="1" <?php if($data->embeddock == 1){echo 'checked="checked" ';}?>>
        </td>
        <td><?php _e("Embed Dock" ); ?></td>
        <td>
        	<input type="hidden" name="facebookdock" value="">
          	<input type="checkbox" id="facebookdock" name="facebookdock" value="1" <?php if($data->facebookdock == 1){echo 'checked="checked" ';}?>>
        </td>
        <td><?php _e("Facebook Dock" ); ?></td>
        <td>
        	<input type="hidden" name="twitterdock" value="">
          	<input type="checkbox" id="twitterdock" name="twitterdock" value="1" <?php if($data->twitterdock == 1){echo 'checked="checked" ';}?>>
        </td>
        <td><?php _e("Twitter Dock" ); ?></td>
      </tr>
    </table>
    <?php  echo "<h3>" . __( 'Color the Player Skin' ) . "</h3>"; ?>
    <table cellpadding="0" cellspacing="10">
      <tr>
        <td width="170"><?php _e("Controlbar Outline Color"); ?></td>
        <td><input type="text" id="controlbaroutlinecolor" name="controlbaroutlinecolor" value="<?php echo $data->controlbaroutlinecolor; ?>" size="50"></td>
      </tr>
      <tr>
        <td><?php _e("Controlbar BG Color"); ?></td>
        <td><input type="text" id="controlbarbgcolor" name="controlbarbgcolor" value="<?php echo $data->controlbarbgcolor; ?>" size="50"></td>
      </tr>
      <tr>
        <td><?php _e("Controlbar Overlay Color"); ?></td>
        <td><input type="text" id="controlbaroverlaycolor" name="controlbaroverlaycolor" value="<?php echo $data->controlbaroverlaycolor; ?>" size="50"></td>
      </tr>
      <tr>
        <td><?php _e("Controlbar Overlay Alpha"); ?></td>
        <td><input type="text" id="controlbaroverlayalpha" name="controlbaroverlayalpha" value="<?php echo $data->controlbaroverlayalpha; ?>" size="50"></td>
      </tr>
      <tr>
        <td><?php _e("Icon Color"); ?></td>
        <td><input type="text" id="iconcolor" name="iconcolor" value="<?php echo $data->iconcolor; ?>" size="50"></td>
      </tr>
      <tr>
        <td><?php _e("Progressbar BG Color"); ?></td>
        <td><input type="text" id="progressbarbgcolor" name="progressbarbgcolor" value="<?php echo $data->progressbarbgcolor; ?>" size="50"></td>
      </tr>
      <tr>
        <td><?php _e("Progressbar Buffer Color"); ?></td>
        <td><input type="text" id="progressbarbuffercolor" name="progressbarbuffercolor" value="<?php echo $data->progressbarbuffercolor; ?>" size="50"></td>
      </tr>
      <tr>
        <td><?php _e("Progressbar Seek Color"); ?></td>
        <td><input type="text" id="progressbarseekcolor" name="progressbarseekcolor" value="<?php echo $data->progressbarseekcolor; ?>" size="50"></td>
      </tr>
      <tr>
        <td><?php _e("Volumebar BG Color"); ?></td>
        <td><input type="text" id="volumebarbgcolor" name="volumebarbgcolor" value="<?php echo $data->volumebarbgcolor; ?>" size="50"></td>
      </tr>
      <tr>
        <td><?php _e("Volumebar Seek Color"); ?></td>
        <td><input type="text" id="volumebarseekcolor" name="volumebarseekcolor" value="<?php echo $data->volumebarseekcolor; ?>" size="50"></td>
      </tr>
      <tr>
        <td><?php _e("Playlist BG Color"); ?></td>
        <td><input type="text" id="playlistbgcolor" name="playlistbgcolor" value="<?php echo $data->playlistbgcolor; ?>" size="50"></td>
      </tr>
    </table>
    <?php  echo "<h3>" . __( 'Gallery Settings' ) . "</h3>"; ?>
    <table cellpadding="0" cellspacing="10">
      <tr>
        <td width="170"><?php _e("No of Rows"); ?></td>
        <td><input type="text" id="rows" name="rows" value="<?php echo $data->rows; ?>" size="50"></td>
      </tr>
      <tr>
        <td><?php _e("No of Cols"); ?></td>
        <td><input type="text" id="cols" name="cols" value="<?php echo $data->cols; ?>" size="50"></td>
      </tr>
      <tr>
        <td><?php _e("Thumbnail Width"); ?></td>
        <td><input type="text" id="thumb_width" name="thumb_width" value="<?php echo $data->thumb_width; ?>" size="50"></td>
      </tr>
      <tr>
        <td><?php _e("Thumbnail Height"); ?></td>
        <td><input type="text" id="thumb_height" name="thumb_height" value="<?php echo $data->thumb_height; ?>" size="50"></td>
      </tr>
    </table>
    <?php  echo "<h3>" . __( 'Custom CSS Settings' ) . "</h3>"; ?>
    <table cellpadding="0" cellspacing="10">
      <tr>
        <td><?php _e("Custom Class for the Player DIV"); ?></td>
        <td><input type="text" id="custom_player_class" name="custom_player_class" value="<?php echo $data->custom_player_class; ?>" size="50"></td>
      </tr>
      <tr>
        <td><?php _e("Style the Player"); ?></td>
        <td><textarea id="player_css" name="player_css" cols="75"  rows="10" ><?php echo $data->player_css; ?></textarea></td>
      </tr>
      <tr>
        <td><?php _e("Custom ID for the Gallery DIV"); ?></td>
        <td><input type="text" id="custom_gallery_id" name="custom_gallery_id" value="<?php echo $data->custom_gallery_id; ?>" size="50"></td>
      </tr>
      <tr>
        <td><?php _e("Style the Gallery"); ?></td>
        <td><textarea id="gallery_css" name="gallery_css" cols="75"  rows="10" ><?php echo $data->gallery_css; ?></textarea></td>
      </tr>
    </table>
    <br />
    <input type="hidden" name="edited" value="true" />
    <input type="submit" class="button-primary" value="<?php _e("Save Options" ); ?>" />
    &nbsp; <a href="?page=allvideogallery_profiles" class="button-secondary" title="cancel"><?php _e("Cancel" ); ?></a>
  </form>
</div>
<script type="text/javascript">
function allvideogallery_validate() {
	if(document.getElementById('width').value < 180 || document.getElementById('height').value < 180) {
		alert("Warning! The Player size should be atleast 180 * 180");
		return false;
	}

	return true;
}
</script>