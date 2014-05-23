import com.gargoylesoftware.htmlunit.WebClient;
import com.gargoylesoftware.htmlunit.html.HtmlPage;
import com.gargoylesoftware.htmlunit.html.DomAttr;
import org.apache.commons.io.FileUtils;
import sun.misc.Version;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.logging.Logger;

import java.io.*;
import java.util.ArrayList;
import java.util.List;
import java.util.logging.Level;
import java.util.zip.ZipEntry;
import java.util.zip.ZipInputStream;


public class Theme {

	public void downloadByName(String name){
		InputStream is = getThemesByName(name);
		ZipInputStream zis = new ZipInputStream(is);
		String themeDir = unzipTheme(zis);
		try{
			FileUtils.moveDirectory(new File(themeDir), new File("WPMY-Site/wp-content/themes/" + themeDir));
		}catch (Exception e){
			System.out.print(e.getMessage());
		}
	}

	public List<String> getAll(){

		List<String> themes = new ArrayList<String>();

		File themesDir = new File("WPMY-Site/wp-content/themes");
		File[] themesList = themesDir.listFiles();
		for(File theme : themesList){
			if(theme.isDirectory()){
				themes.add(theme.getName());
			}
		}

		return themes;
	}

	public void set(String name){
		Connection con = null;
		Statement st = null;

		try {
			con = DriverManager.getConnection("jdbc:mysql://localhost/wordpress", "root", "pluto52");
			st = con.createStatement();
			st.executeUpdate("UPDATE `wp_options` SET `option_value` = '" + name + "' WHERE `option_name` = 'stylesheet' || `option_name` = 'template'");
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

	private InputStream getThemesByName(String name){
		java.util.logging.Logger.getLogger("com.gargoylesoftware").setLevel(Level.OFF);

		WebClient webClient = new WebClient();
		try{
			final HtmlPage allThemesPage = webClient.getPage("http://wordpress.org/themes/search.php?q="+name);
			final DomAttr themePageLinkAttr = allThemesPage.getFirstByXPath("//*[@id=\"pagebody\"]/div/div[2]/ol/li/h4/a/@href");
			final HtmlPage currentThemePage = webClient.getPage("http://wordpress.org/" + themePageLinkAttr.getTextContent());
			final DomAttr themeDownloadLinkAttr = currentThemePage.getFirstByXPath("//*[@id=\"pagebody\"]/div/div[2]/div/div[2]/p[1]/a/@href");
			final String downloadLink = "http:"+themeDownloadLinkAttr.getTextContent();

			InputStream in = webClient.getPage(downloadLink).getWebResponse().getContentAsStream();

			return in;
		}catch (Exception e){
			System.out.print(e.getMessage());
		}
		return null;
	}

	private String unzipTheme(ZipInputStream zis){

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