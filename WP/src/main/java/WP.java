import org.eclipse.jetty.server.Server;
import org.eclipse.jetty.webapp.*;
import org.eclipse.jetty.servlet.ServletHolder;

import com.caucho.quercus.servlet.*;


public class WP{
	Theme theme;
	Plugin plugin;
	Test test;
	public WP(){
		theme = new Theme();
		plugin = new Plugin();
		test = new Test();
	}

	public static void start(String WPSiteDirector){
		Server server = new Server(8080);

		WebAppContext context = new WebAppContext();
		context.setResourceBase(WPSiteDirector);
		context.setContextPath("/");
		context.addServlet(QuercusServlet.class.getName(),"/*.php");
		System.err.println(QuercusServlet.class.getName());

		QuercusServlet servlet = new QuercusServlet();

		servlet.createPhpIni();
		try{
			servlet.init();
		}catch (Exception e){
			System.out.print(e.getMessage());
		}
		context.addServlet(new ServletHolder(QuercusServlet.class),"*.php");

		server.setHandler(context);
		context.getInitParams().put("license-directory", "WEB-INF/licenses");
		context.getInitParams().put("compile", "true");
		context.getInitParams().put("database", "UTF-8");
		context.getInitParams().put("script-encoding", "jdbc/test");
		context.getInitParams().put("ini-file", "WEB-INF/php.ini");

		servlet.setCompile("true");
		servlet.setCompileFailover("true");

		try{
			server.start();
			server.join();
		}catch (Exception e){
			System.out.print(e.getMessage());
		}
	}
}