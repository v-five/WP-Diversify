=== All Video Gallery Plugin for WordPress ===
Contributors: Mr Vinoth
Tags: hd, flash, flv, swf, video, plugin, player, gallery, allvideogallery, videogallery, videoplayer, flvplayer, html5, image, iPad, iphone, ipod, playlists, rtmp
Requires at least: 2.8.6
Tested up to: 3.3.1
Stable tag: 1.0

Add Videos to your Post, build Video Galleries and show Featured, Popular, Latest & Random videos.

== Description ==

<strong>Video Player Demo :</strong> http://allvideogallery.mrvinoth.com/livedemo/?slg=300-warriors

We are proud to announce the first Video share solution for WordPress. Using All Video Gallery, you can build websites like Youtube, Vimeo and Dailymotion in less than an hour. This Extension contain several features like adding Videos to your Post, building Video Galleries and showing Featured, Popular, Latest & Random videos. More than all, this extension has HTML5 fallback for Mobile devices. So, your videos can also be viewed in mobile devices with some limitations.

<strong>Features include:</strong>

* Supported Media formats : flv, mp4, 3g2, 3gp, aac, f4b, f4p, f4v, m4a, m4v, mov(h.264), sdp, vp6.
* HTML5 fallback.
* Simplified Shortcode to add Players and Thumbnail galleries either to your Posts [or] Pages.
* Thumbnail Galleries can be built based on Categories or Latest, Featured, Popular and Random Videos.
* Widget option to add Thumbnail galleries to your website's sidebar.
* Coloring the player skin.
* Adding or Removing skin elements.
* Facebook and Twitter Share.
* Related Videos inside the Player.
* Branding of the Player.
* Option to add Videos by simply providing the Video URL.
* Youtube API to play Youtube videos.
* True Streaming methods like RTMP and Lighttpd.
* CDN streaming like Amazon Cloudfront, Highwinds SMIL and Bitgravity Streaming.
* Option to add Third party Embedcodes.

== Installation ==

<strong>Installing All Video Gallery plugin can be achieved in two easy methods:</strong>

1. Uploading Manually via WordPress Admin.
2. Uploading Manually via FTP.

<strong>Uploading Manually via WordPress Admin :</strong>

1. Download the latest package.
2. From the WordPress plugin menu click on Add New.
3. Under the Upload menu, Use the Browse button to select the plugin zip file that was downloaded, then click on Install Now. The plugin will be uploaded to your site and installed. It can then be activated.

<strong>Uploading Manually via FTP :</strong>

1. Download the latest package and unzip the plugin.
2. Now you will need to upload the plugin to your site's wp-content/plugins/ directory using FTP.
3. Congrats! You have installed the Plugin. It can then be activated.

== Upgrade Notice ==

It is recommended that you back up your custom players if you are upgrading.
You can perform the automatic update, download the plugin and upload, or FTP the plugin to the plugins folder directly.

== Requirements ==

* WordPress 2.8.6 or higher
* PHP 5.0 or higher

== Usage ==

<strong>Adding All Video Gallery to your blog require 3 necessary steps :</strong>

1. Building an All Video Gallery Profile.
2. Creating a Video Category.
3. Adding your Video to the Category.

<strong>Step 1 : Building an All Video Gallery Profile</strong>

All Video Gallery profiles are used to determine how your player should be and how your gallery page should look like in front-end. You can create multiple profiles and one of these Profile ID will be used along with the Plugin Shortcode to design your front-end.<br />
Example : [allvideogallery profile=1]

<strong>Step 2 : Creating a Video Category</strong>

Assume that you have hundreds of videos, without categorization it's not easy to manage all your videos. So, we have made the categorization to be mandatory. So the next step after building the profile would be creating a category. Tweaking the category input in the Plugin Shortcode will create more effects in front-end gallery view.<br />
Example 1 : [allvideogallery profile=1] will show all categories in the gallery format.<br />
Example 2 : [allvideogallery profile=1 category=1] will show all videos of the particular category ( of which id is set to 1 ) in the gallery format.

<strong>Step 3 : Adding your Video to the Category</strong>

Now, it's time to add your Video to the category. Other than the gallery display, All Video Gallery has option to add the player with a single Video using the particular Video ID.<br />
Example : [allvideogallery profile=1 video=1]

<strong>Additional Sorting Options</strong>

Using sort attribute with the Plugin Shortcode will allow you to sort (or) filter your gallery view in 4 formats.<br />
1. latest  2. popular  3. random  4. featured<br />
Example 1 : [allvideogallery profile=1 sort=latest] will display recently added videos from all categories.<br />
Still you can filter the results based on any particular category as below,<br />
Example 2 : [allvideogallery profile=1 sort=latest category=1]

<strong>Note : </strong>Additionally, All Video Gallery has a Video Gallery Widget which could be added in your website's sidebar.

== Changelog ==

= 1.0.0 =
* Initial release of the All Video Gallery Plugin for WordPress