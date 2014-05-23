<?php

/******************************************************************
/* Inserting (or) Updating the DB Table when edited
******************************************************************/
if($_POST['edited'] == 'true' && check_admin_referer( 'allvideogallery-nonce')) {
    $_POST['slug'] = ( $_POST['slug'] != '' ) ? sanitize_title( $_POST['slug'] ) : sanitize_title( $_POST['name'] );
	unset($_POST['group'], $_POST['edited'], $_POST['_wpnonce'], $_POST['_wp_http_referer']);
	$wpdb->update($table_name, $_POST, array('id' => $_GET['id']));
	echo '<script>window.location="?page=allvideogallery_categories";</script>';
}

/******************************************************************
/* Getting Input from the DB Table
******************************************************************/
$data = $wpdb->get_row("SELECT * FROM $table_name WHERE id=".$_GET['id']);
	
?>

<div class="wrap">
  <form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>" onsubmit="return allvideogallery_validate();">
    <?php wp_nonce_field('allvideogallery-nonce'); ?>
    <?php  echo "<h3>" . __( 'Add a New Category' ) . "</h3>"; ?>
    <table cellpadding="0" cellspacing="10">
      <tr>
        <td width="30%"><?php _e("Name"); ?></td>
        <td style="padding-left:5px;"><i><?php echo $data->name; ?></i></td>
      </tr>
      <tr>
        <td width="30%"><?php _e("Slug"); ?></td>
        <td><input type="text" id="slug" name="slug" value="<?php echo $data->slug; ?>" size="50"></td>
      </tr>
      <tr>
        <td><?php _e("Thumb"); ?></td>
        <td><input type="text" id="thumb" name="thumb" value="<?php echo $data->thumb; ?>"  size="50"></td>
      </tr>
      <tr>
        <td class="key"><?php _e("Published"); ?></td>
        <td>
        	<input type="hidden" name="published" value="">
          	<input type="checkbox" id="published" name="published" value="1" checked="checked" <?php if($data->published == 1){echo 'checked="checked" ';}?> />
        </td>
      </tr>
    </table>
    <br />
    <input type="hidden" name="edited" value="true" />
    <input type="hidden" name="name" value="<?php echo $data->name; ?>" />
    <input type="submit" class="button-primary" value="<?php _e("Save Options" ); ?>" />
    &nbsp; <a href="?page=allvideogallery_categories" class="button-secondary" title="cancel"><?php _e("Cancel" ); ?></a>
  </form>
</div>
<script type="text/javascript">
function allvideogallery_validate() {
	var imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
	var isAllowed       = true;
	
	if(document.getElementById('name').value == '') {
		alert('<?php _e("You must add a Category Name."); ?>');
		return false;
	}
	
	if(!document.getElementById('thumb').value) {
		alert('<?php _e("You must add a Thumb Image to the Category."); ?>');
		return false;
	}
	
	isAllowed = checkExtension('IMAGE', document.getElementById('thumb').value, imageExtensions);
	if(isAllowed == false) 	return false;
	
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