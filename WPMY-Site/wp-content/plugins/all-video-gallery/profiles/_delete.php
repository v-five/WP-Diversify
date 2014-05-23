<?php

/******************************************************************
/* Deleting the Table Row
******************************************************************/
if($_GET['page'] == 'allvideogallery_profiles' && $_GET['opt'] == 'delete') {
	$wpdb->query("DELETE FROM $table_name WHERE id=".$_GET['id']);
	echo '<script>window.location="?page=allvideogallery_profiles";</script>';
}

?>