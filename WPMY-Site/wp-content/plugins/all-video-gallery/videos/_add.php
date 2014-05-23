<?php

/******************************************************************
/* Inserting (or) Updating the DB Table when edited
******************************************************************/
if($_POST['edited'] == 'true' && check_admin_referer( 'allvideogallery-nonce')) {
	if( get_magic_quotes_gpc() ) {
    	$_POST = array_map( 'stripslashes_deep', $_POST );
	}
	$_POST['slug'] = ( $_POST['slug'] != '' ) ? sanitize_title( $_POST['slug'] ) : sanitize_title( $_POST['title'] );
	unset($_POST['group'], $_POST['edited'], $_POST['_wpnonce'], $_POST['_wp_http_referer']);
	$wpdb->insert($table_name, $_POST);	
	if(!$_POST['ordering']) {
		$insert_id = $wpdb->insert_id;
		$wpdb->update($table_name, array('ordering' => $insert_id), array('id' => $insert_id));
	}
	echo '<script>window.location="?page=allvideogallery_videos";</script>';
}
	
?>

<div class="wrap">
  <form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>" onsubmit="return allvideogallery_validate();">
    <?php wp_nonce_field('allvideogallery-nonce'); ?>
    <?php  echo "<h3>" . __( 'Add a New Video' ) . "</h3>"; ?>
    <table cellpadding="0" cellspacing="10">
      <tr>
        <td width="30%"><?php _e("Title"); ?></td>
        <td><input type="text" id="title" name="title" size="50"></td>
      </tr>
      <tr>
        <td width="30%"><?php _e("Slug"); ?></td>
        <td><input type="text" id="slug" name="slug" size="50"></td>
      </tr>
      <tr>
        <td class="key"><?php _e("Type"); ?></td>
        <td>
        	<select id="type" name="type" onchange="javascript:changeType(this.options[this.selectedIndex].id);">
            	<option value="url" id="url" ><?php _e("Direct URL"); ?></option>
            	<option value="youtube" id="youtube" ><?php _e("Youtube"); ?></option>
            	<option value="rtmp" id="rtmp" ><?php _e("RTMP Streaming"); ?></option>
            	<option value="lighttpd" id="lighttpd" ><?php _e("Lighttpd"); ?></option>
            	<option value="highwinds" id="highwinds" ><?php _e("Highwinds"); ?></option>
            	<option value="bitgravity" id="bitgravity" ><?php _e("Bitgravity"); ?></option>
            	<option value="thirdparty" id="thirdparty" ><?php _e("Thirdparty Embedcode"); ?></option>
          	</select>
        </td>
      </tr>
      <tr id="_streamer">
        <td class="key"><?php _e("Streamer" ); ?></td>
        <td><input type="text" id="streamer" name="streamer" size="50" /></td>
      </tr>
      <tr id="_video">
        <td width="30%"><?php _e("Video"); ?></td>
        <td><input type="text" id="video" name="video" size="50"></td>
      </tr>
      <tr id="_hdvideo">
        <td width="30%"><?php _e("HD Video"); ?></td>
        <td><input type="text" id="hd" name="hd" size="50"></td>
      </tr>
      <tr id="_thirdparty">
        <td class="key"><?php _e("Embedcode" ); ?></td>
        <td><textarea id="thirdparty" name="thirdparty" cols="52"  rows="10" ></textarea></td>
      </tr>
      <tr id="_token">
        <td class="key"><?php _e("Token" ); ?></td>
        <td><input type="text" id="token" name="token" size="50" /></td>
      </tr>
      <tr>
        <td><?php _e("Thumb"); ?></td>
        <td><input type="text" id="thumb" name="thumb" size="50"></td>
      </tr>
      <tr id="_preview">
        <td><?php _e("Preview"); ?></td>
        <td><input type="text" id="preview" name="preview" size="50"></td>
      </tr>
      <tr>
        <td class="key"><?php _e("Description" ); ?></td>
        <td><textarea id="description" name="description" cols="52"  rows="10" ></textarea></td>
      </tr>
      <tr>
        <td class="key"><?php _e("Category"); ?></td>
        <td>
        	<select id="category" name="category" >
            	<?php
            	$k=count( $categories);
            	for ($i=0; $i < $k; $i++)
            	{
               		$row = $categories[$i];
            	?>
            	<option value="<?php echo $row->name; ?>" id="<?php echo $row->name; ?>"><?php echo $row->name; ?></option>
            	<?php } ?>
         	</select>
        </td>
      </tr>
      <tr>
        <td width="30%"><?php _e("Ordering"); ?></td>
        <td><input type="text" id="ordering" name="ordering" size="50"></td>
      </tr>
      <tr id="_dvr">
        <td class="key"><?php _e("DVR"); ?></td>
        <td>
        	<input type="hidden" name="dvr" value="">
          	<input type="checkbox" id="dvr" name="dvr" value="1" />
        </td>
      </tr>
      <tr>
        <td class="key"><?php _e("Featured"); ?></td>
        <td>
        	<input type="hidden" name="featured" value="">
          	<input type="checkbox" id="featured" name="featured" value="1" />
        </td>
      </tr>
      <tr>
        <td class="key"><?php _e("Published"); ?></td>
        <td>
        	<input type="hidden" name="published" value="">
          	<input type="checkbox" id="published" name="published" value="1" checked="checked" />
        </td>
      </tr>
    </table>
    <br />
    <input type="hidden" name="edited" value="true" />
    <input type="submit" class="button-primary" value="<?php _e("Save Options" ); ?>" />
    &nbsp; <a href="?page=allvideogallery_videos" class="button-secondary" title="cancel"><?php _e("Cancel" ); ?></a>
  </form>
</div>
<script type="text/javascript">

changeType("url");

function changeType(typ) {

	document.getElementById('_video').style.display="none";
	document.getElementById('_hdvideo').style.display="none";
	document.getElementById('_preview').style.display="none";
	document.getElementById('_streamer').style.display="none";
	document.getElementById('_dvr').style.display="none";
	document.getElementById('_token').style.display="none";
	document.getElementById('_thirdparty').style.display="none";

	switch(typ) {
		case 'url' :
		case 'lighttpd' :
			document.getElementById('_video').style.display="";
			document.getElementById('_hdvideo').style.display="";
			document.getElementById('_preview').style.display="";
			break;
		case 'rtmp' :
			document.getElementById('_video').style.display="";
            document.getElementById('_hdvideo').style.display="";
			document.getElementById('_preview').style.display="";
			document.getElementById('_streamer').style.display="";
			document.getElementById('_token').style.display="";
			break;
		case 'youtube' :
		case 'highwinds' :
			document.getElementById('_video').style.display="";
			document.getElementById('_preview').style.display="";
			break;
		case 'bitgravity' :
			document.getElementById('_video').style.display="";
			document.getElementById('_dvr').style.display="";
			document.getElementById('_preview').style.display="";
			break;
		case 'thirdparty' :
			document.getElementById('_thirdparty').style.display="";
			break;		
		}
}

function allvideogallery_validate() {
	var type            = document.getElementById("type");
    var method          = type.options[type.selectedIndex].value;
	var category        = <?php echo count($categories); ?>;
	var videoExtensions = ['flv', 'mp4' , '3g2', '3gp', 'aac', 'f4b', 'f4p', 'f4v', 'm4a', 'm4v', 'mov', 'sdp', 'vp6', 'smil'];
	var imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
	var isAllowed       = true;
	
	if(document.getElementById('title').value == '') {
		alert('<?php _e("You must add a Title for the Video."); ?>');
		return false;
	}
	
	if(method != 'thirdparty' && document.getElementById('video').value == '') {
		alert('<?php _e("You have not added any Video to the Player."); ?>');
		return false;
	} else if(method == 'thirdparty' && document.getElementById('thirdparty').value == '') {
		alert('<?php _e("You have not added any Thirdparty EmbedCode."); ?>');
		return false;
	}
	
	if(method == 'url' || method == 'highwinds' || method == 'lighttpd') {
		isAllowed = checkExtension('VIDEO', document.getElementById('video').value, videoExtensions);
		if(isAllowed == false) 	return false;
		
		if(document.getElementById('hd').value) {
			isAllowed = checkExtension('VIDEO', document.getElementById('hd').value, videoExtensions);
			if(isAllowed == false) 	return false;
		}
	}
	
	if(document.getElementById('thumb').value == '') {
		alert('<?php _e("You must add a Thumb Image to the Video."); ?>');
		return false;
	} else {	
		isAllowed = checkExtension('IMAGE', document.getElementById('thumb').value, imageExtensions);
		if(isAllowed == false) 	return false;
	}
	
	if(document.getElementById('preview').value) {
		isAllowed = checkExtension('IMAGE', document.getElementById('preview').value, imageExtensions);
		if(isAllowed == false) 	return false;
	}	
	
	if(category < 1) {
		alert('<?php _e("You must add a Category to the Video."); ?>');
		return false;
	}
	
	return true;
	
}

function checkExtension(type, filePath, validExtensions) {
    var ext = filePath.substring(filePath.lastIndexOf('.') + 1).toLowerCase();

    for(var i = 0; i < validExtensions.length; i++) {
        if(ext == validExtensions[i]) return true;
    }

    alert(type + ' :   The file extension ' + ext.toUpperCase() + ' is not allowed!');
    return false;	
}
</script>