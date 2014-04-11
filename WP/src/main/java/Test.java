import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.chrome.ChromeDriver;
import org.sikuli.script.Screen;

/**
 * Created by v-five on 3/31/14.
 */
public class Test {
	public static void doTests(){

		System.setProperty("webdriver.chrome.driver", "WP/chromedriver");
		WebDriver driver = new ChromeDriver();
		Screen screen = new Screen();
		driver.get("localhost:8080");

		if(driver.getTitle().equals("Diversify | A WordPress site for DIVERSIFY project") || driver.getTitle().equals("Diversify")){
			System.out.println("1 test passed!");
		}else {
			System.out.println("1 test failed!");
		}


		try{
			screen.click("WP/imgs/cofe.png");
			if(driver.getTitle().equals("Just another post | Diversify")){
				System.out.println("2 test passed!");
			}else {
				System.out.println("2 test failed!");
			}
		}catch (Exception e){
			System.out.print("2 test failed! - ");
			System.out.println(e.getMessage());
		}


		try{
			driver.findElement(By.linkText("Just another page")).click();
			if(driver.getTitle().equals("Just another page | Diversify")){
				System.out.println("3 test passed!");
			}else {
				System.out.println("3 test failed!");
			}
		}catch (Exception e){
			System.out.print("3 test failed! - ");
			System.out.println(e.getMessage());
		}


		driver.quit();
	}
}
