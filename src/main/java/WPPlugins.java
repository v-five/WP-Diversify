import java.util.List;

/**
 * Created by v-five on 3/20/14.
 */
public class WPPlugins {
	public static void main(String args[]){
		WP wp = new WP();

		//Download a plugin
//		wp.plugin.downloadByName("photo");


//		Return a list with all accessible plugins
//		List<String> allPlugins = wp.plugin.getAll();
//		System.out.println(allPlugins);

//		List<String> enabledPlugins = wp.plugin.getEnabled();
//		System.out.println(allPlugins);

		List<String> disabledPlugins = wp.plugin.getDisabled();
		System.out.println(disabledPlugins);



		//Set a plugin on WordPress
		//calendar/calendar.php
//		wp.plugin.enable("");
	}
}
//plugins.php?action=activate&plugin=wp-photo-album-plus/wppa.php"