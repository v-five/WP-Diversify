import com.gargoylesoftware.htmlunit.BrowserVersion;
import com.gargoylesoftware.htmlunit.StringWebResponse;
import com.gargoylesoftware.htmlunit.WebClient;
import com.gargoylesoftware.htmlunit.html.DomAttr;
import com.gargoylesoftware.htmlunit.html.HTMLParser;
import com.gargoylesoftware.htmlunit.html.HtmlPage;
import com.gargoylesoftware.htmlunit.javascript.JavaScriptEngine;
import de.ailis.pherialize.MixedArray;
import de.ailis.pherialize.Pherialize;
import org.apache.commons.io.FileUtils;

import java.io.File;
import java.io.FileOutputStream;
import java.io.InputStream;
import java.net.URL;
import java.net.URLConnection;
import java.sql.*;
import java.util.ArrayList;
import java.util.List;
import java.util.Scanner;
import java.util.logging.Level;
import java.util.logging.Logger;
import java.util.regex.Matcher;
import java.util.regex.Pattern;
import java.util.zip.ZipEntry;
import java.util.zip.ZipInputStream;


public class Plugin {

	public void downloadByName(String name){
		InputStream is = getPluginByName(name);
		ZipInputStream zis = new ZipInputStream(is);
		String pluginDir = unzipPlugin(zis);
		try{
			FileUtils.moveDirectory(new File(pluginDir), new File("WP-Site/wp-content/plugins/" + pluginDir));
		}catch (Exception e){
			System.out.print(e.getMessage());
		}
	}

	public List<String> getAll(){

		List<String> plugins = new ArrayList<String>();

		File pluginsDir = new File("WP-Site/wp-content/plugins");
		File[] pluginsList = pluginsDir.listFiles();
		for(File plugin : pluginsList){
			if(plugin.isDirectory()){
				plugins.add(plugin.getName());
			}
		}

		return plugins;
	}

	public List<String> getEnabled(){
		Connection con = null;
		Statement st = null;
		List<String> plugins = new ArrayList<String>();
		try {
			con = DriverManager.getConnection("jdbc:mysql://localhost/wordpress", "root", "pluto52");
			st = con.createStatement();
			ResultSet res = st.executeQuery("SELECT `option_value` FROM `wp_options` WHERE `option_name` = 'active_plugins'");
			res.next();
			String phpSerializedArray = res.getString("option_value");
			MixedArray mixedArrayList = Pherialize.unserialize(phpSerializedArray).toArray();

			for(int i = 0; i < mixedArrayList.size(); i++)
				plugins.add(mixedArrayList.getString(i));


		} catch (SQLException e) {
			System.out.print(e.getMessage());
		} finally {
			try {
				if (st != null) st.close();
				if (con != null) con.close();
			} catch (SQLException e) {
				System.out.print(e.getMessage());
			}
		}
		return plugins;
	}



	public List<String> getDisabled(){
		List<String> plugins = new ArrayList<String>();

		List<String> allPlugins = getAll();
		List<String> enabledPlugins = getEnabled();
		boolean flag = false;

		for(int i=0; i < allPlugins.size(); i++){
			for(int j=0; j < enabledPlugins.size(); j++)
				if(enabledPlugins.get(j).contains(allPlugins.get(i))) flag = true;
			if(!flag) plugins.add(allPlugins.get(i));
		}

		return plugins;
	}

	public void enable(String plugin){
		Connection con = null;
		Statement st = null;

		try {
			con = DriverManager.getConnection("jdbc:mysql://localhost/wordpress", "root", "pluto52");
			st = con.createStatement();
			ResultSet res = st.executeQuery("SELECT `option_value` FROM `wp_options` WHERE `option_name` = 'active_plugins'");
			res.next();
			String phpSerializedArray = res.getString("option_value");
			MixedArray mixedArrayList = Pherialize.unserialize(phpSerializedArray).toArray();

			mixedArrayList.put(mixedArrayList.size(), plugin);

			String phpSerializedPlugins = Pherialize.serialize(mixedArrayList);

			st.executeUpdate("UPDATE `wp_options` SET `option_value` = '" + phpSerializedPlugins + "' WHERE `option_name` = 'active_plugins'");
		} catch (SQLException e) {
			System.out.print(e.getMessage());
		} finally {
			try {
				if (st != null) st.close();
				if (con != null) con.close();
			} catch (SQLException e) {
				System.out.print(e.getMessage());
			}
		}
	}

	public void disable(String plugin){
		Connection con = null;
		Statement st = null;

		try {
			con = DriverManager.getConnection("jdbc:mysql://localhost/wordpress", "root", "pluto52");
			st = con.createStatement();
			ResultSet res = st.executeQuery("SELECT `option_value` FROM `wp_options` WHERE `option_name` = 'active_plugins'");
			res.next();
			String phpSerializedArray = res.getString("option_value");
			MixedArray mixedArrayList = Pherialize.unserialize(phpSerializedArray).toArray();

			List plugins = new ArrayList();
			for(int i = 0; i < mixedArrayList.size(); i++)
				if(!plugin.equals(mixedArrayList.getString(i))) plugins.add(mixedArrayList.getString(i));

			String phpSerializedPlugins = Pherialize.serialize(plugins);

			st.executeUpdate("UPDATE `wp_options` SET `option_value` = '" + phpSerializedPlugins + "' WHERE `option_name` = 'active_plugins'");
		} catch (SQLException e) {
			System.out.print(e.getMessage());
		} finally {
			try {
				if (st != null) st.close();
				if (con != null) con.close();
			} catch (SQLException e) {
				System.out.print(e.getMessage());
			}
		}
	}

	private InputStream getPluginByName(String name){
		Logger.getLogger("com.gargoylesoftware").setLevel(Level.OFF);

		try{
			URLConnection connection =  new URL("http://wordpress.org/plugins/search.php?q="+name).openConnection();
			Scanner scanner = new Scanner(connection.getInputStream());
			scanner.useDelimiter("\\Z");
			String content = scanner.next();

			Pattern pattern = Pattern.compile("a\\shref=\\\"http:\\/\\/wordpress\\.org\\/plugins\\/(.*?)\\/");
			Matcher mathcer = pattern.matcher(content);
			mathcer.find();
			String pluginName = mathcer.group(1);

			connection =  new URL("http://wordpress.org/plugins/"+pluginName).openConnection();
			scanner = new Scanner(connection.getInputStream());
			scanner.useDelimiter("\\Z");
			content = scanner.next();

			pattern = Pattern.compile("a\\sitemprop='downloadUrl'\\shref='(.*?)'>");
			mathcer = pattern.matcher(content);
			mathcer.find();
			String downloadLink = mathcer.group(1);
			WebClient webClient = new WebClient();
			InputStream in = webClient.getPage(downloadLink).getWebResponse().getContentAsStream();

			return in;
		}catch (Exception e){
			System.out.println(e.getMessage());
		}
		return null;
	}

	private String unzipPlugin(ZipInputStream zis){

		try{
			ZipEntry ze = zis.getNextEntry();
			String outputDir = ze.getName();

			while(ze!=null){
				File f = new File(ze.getName());
				if(ze.isDirectory()){
					f.mkdir();
					ze = zis.getNextEntry();
					continue;
				}

				FileOutputStream fos = new FileOutputStream(f);
				int len;
				byte bytes[] = new byte[1024];
				while ((len = zis.read(bytes)) > 0) {
					fos.write(bytes, 0, len);
				}
				fos.close();
				ze = zis.getNextEntry();
			}
			zis.closeEntry();
			zis.close();

			return outputDir;
		}catch (Exception e){
			System.out.print(e.getMessage());
		}

		return null;

	}
}