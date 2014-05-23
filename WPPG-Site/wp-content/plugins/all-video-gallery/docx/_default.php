<div class="wrap" style="line-height:2;">
<?php  

/******************************************************************
/* Usage
******************************************************************/
echo "<h3 style='color:#21759B;'>" . __( "Adding All Video Gallery to your blog require 3 necessary steps :" ) . "</h3>";
_e( "1. Building an All Video Gallery Profile." );
echo "<br />";
_e( "2. Creating a Video Category." );
echo "<br />";
_e( "3. Adding your Video to the Category." );

echo "<h3>" . __( "Step 1 : Building an All Video Gallery Profile" ) . "</h3>";
_e( "<strong>All Video Gallery</strong> profiles are used to determine how your player should be and how your gallery page should look like in front-end. You can create multiple profiles and one of these <strong>Profile ID</strong> will be used along with the <strong>Plugin Shortcode</strong> to design your front-end.<br /><i><strong>Example : </strong> [allvideogallery profile=1]</i>." );

echo "<h3>" . __( "Step 2 : Creating a Video Category" ) . "</h3>";
_e( "Assume that you have hundreds of videos, without categorization it's not easy to manage all your videos. So, we have made the categorization to be mandatory. So the next step after building the profile would be creating a category. Tweaking the category input in the <strong>Plugin Shortcode</strong> will create more effects in front-end gallery view.<br /><i><strong>Example 1 : </strong>[allvideogallery profile=1]</i> will show all categories in the gallery format.<br /><i><strong>Example 2 : </strong>[allvideogallery profile=1 category=1]</i> will show all videos of the particular category ( of which id is set to 1 ) in the gallery format." );

echo "<h3>" . __( "Step 3 : Adding your Video to the Category" ) . "</h3>";
_e( "Now, it's time to add your Video to the category. Other than the gallery display, All Video Gallery has option to add the player with a single Video using the particular <strong>Video ID.</strong><br /><i><strong>Example : </strong> [allvideogallery profile=1 video=1]</i>." );

echo "<h3>" . __( "Additional Sorting Options" ) . "</h3>";
_e( "Using <strong>sort</strong> attribute with the <strong>Plugin Shortcode</strong> will allow you to <strong>sort (or) filter</strong> your gallery view in 4 formats.<br /><strong>1. latest&nbsp;&nbsp;2. popular&nbsp;&nbsp;3. random&nbsp;&nbsp;4. featured</strong><br /><i><strong>Example 1 : </strong>[allvideogallery profile=1 sort=latest]</i> will display recently added videos from all categories.<br />Still you can filter the results based on a particular category as below,<br /><i><strong>Example 2 : </strong>[allvideogallery profile=1 sort=latest category=1]</i>." );

echo "<h3>" . __( "Where the Auto Detection attribute is Used ?" ) . "</h3>";
_e( "Our Video Player has option to show list of Videos inside the Player. Assume that you have more than a Video Player in the same Page. While a thumb option is selected from the list inside the Player, the Page will be refreshed and the selected video will start playing in all the available players from the page. To control this, we introduce a new attribute called <strong>autodetecion</strong>. By default, this option is enabled. Disabling this option will protect other Players from playing the selected option. Following is the example which does it,<br /><i>[allvideogallery profile=1 video=1 autodetect=0]</i>" );

echo "<br />";
echo "<br />";
_e( "<strong>Note : </strong>Additionally, All Video Gallery has a Video Gallery Widget which could be added in your website's sidebar. <a href='http://allvideogallery.mrvinoth.com/using-the-widget' target='_blank'>Learn more</a>" );

?>
</div>