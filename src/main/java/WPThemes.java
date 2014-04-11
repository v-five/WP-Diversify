import java.util.List;
import java.util.Random;

/**
 * Created by v-five on 3/20/14.
 */
public class WPThemes {
	public static void main(String args[]){
		WP wp = new WP();

		//Download a theme
		wp.theme.downloadByName("dust");


		//Return a list with all accessible themes
		List<String> allThemes = wp.theme.getAll();
		System.out.print(allThemes);


		//Set a theme on WordPress
//		wp.theme.set("test");


		//Set a random theme
//		List<String> allThemes = wp.theme.getAll();
//		wp.theme.set(
//				allThemes.get(
//						(int)(Math.random() * allThemes.size()
//						)
//				)
//		);
	}
}
