<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 * 
 */

function optionsframework_option_name() {
	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = 'venom';
	
	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */

function optionsframework_options() {
	
	// Test data
	$magpro_slider_start = array("false" => __("No", 'venom' ),"true" => __("Yes", 'venom' ));
	
	// Pull all the categories into an array
	$options_categories = array();  
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
    	$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Pull all the pages into an array
	$options_pages = array();  
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = __('Select a page:', 'venom' );
	foreach ($options_pages_obj as $page) {
    	$options_pages[$page->ID] = $page->post_title;
	}
		
	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri(). '/admin/images/';
		
	$options = array();
		
		
							
	$options[] = array( "name" => "country1",
						"type" => "innertabopen");	

		$options[] = array( "name" => __("Select a Skin", 'venom' ),
							"type" => "groupcontaineropen");	

				$options[] = array( "name" => __("Select a Skin", 'venom' ),
										"desc" => __("If you are not using child theme, selecting child theme will be same as using venom skin. If you are using child theme, then lite.css from the child theme will be used.", 'venom' ),
										"id" => "skin_style",
										"type" => "images",
										"std" => "venom",
										"options" => array(
											'venom' => $imagepath . 'venom.png',
											'radi' => $imagepath . 'radi.png',
											'maroon' => $imagepath . 'maroon.png',
											'green' => $imagepath . 'green.png',
											'brown' => $imagepath . 'brown.png',
											'purple' => $imagepath . 'purple.png',
											'yellow' => $imagepath . 'yellow.png',
											'child' => $imagepath . 'child.png')
										);						

										
		$options[] = array( "type" => "groupcontainerclose");
		
		$options[] = array( "name" => __("Single Post Settings", 'venom' ),
							"type" => "groupcontaineropen");
							
					$options[] = array( "name" => __("Show Featured Image?", 'venom' ),
										"desc" => __("Select yes if you want to show featured image.", 'venom' ),
										"id" => "show_featured_image_single",
										"std" => "false",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show Ratings?", 'venom' ),
										"desc" => __("Select yes if you want to show ratings under post title.", 'venom' ),
										"id" => "show_rat_on_single",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);										
										
					$options[] = array( "name" => __("Show Posted by and Date?", 'venom' ),
										"desc" => __("Select yes if you want to show Posted by and Date under post title.", 'venom' ),
										"id" => "show_pd_on_single",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);											
										
					$options[] = array( "name" => __("Show Categories and Tags?", 'venom' ),
										"desc" => __("Select yes if you want to show categories under post title.", 'venom' ),
										"id" => "show_cats_on_single",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show Next/Previous Box", 'venom' ),
										"desc" => __("Select yes if you want to show Next/Previous box on single post page.", 'venom' ),
										"id" => "show_np_box",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);	
																																							
										
		$options[] = array( "type" => "groupcontainerclose");						
		
		
		
	$options[] = array( "type" => "innertabclose");	


	$options[] = array( "name" => "country2",
						"type" => "innertabopen");	
						
		$options[] = array( "name" => __("Social Settings", 'venom' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Twitter", 'venom' ),
										"desc" => __("Enter your twitter id", 'venom' ),
										"id" => "twitter_id",
										"std" => "",
										"type" => "text");

					$options[] = array( "name" => __("Redditt", 'venom' ),
										"desc" => __("Enter your reddit url", 'venom' ),
										"id" => "redit_id",
										"std" => "",
										"type" => "text");

					$options[] = array( "name" => __("Facebook", 'venom' ),
										"desc" => __("Enter your facebook url", 'venom' ),
										"id" => "facebook_id",
										"std" => "",
										"type" => "text");

					$options[] = array( "name" => __("Stumble", 'venom' ),
										"desc" => __("Enter your stumbleupon url", 'venom' ),
										"id" => "stumble_id",
										"std" => "",
										"type" => "text");

					$options[] = array( "name" => __("Flickr", 'venom' ),
										"desc" => __("Enter your flickr url", 'venom' ),
										"id" => "flickr_id",
										"std" => "",
										"type" => "text");

					$options[] = array( "name" => __("LinkedIn", 'venom' ),
										"desc" => __("Enter your linkedin url", 'venom' ),
										"id" => "linkedin_id",
										"std" => "",
										"type" => "text");

					$options[] = array( "name" => __("Google", 'venom' ),
										"desc" => __("Enter your google url", 'venom' ),
										"id" => "google_id",
										"std" => "",
										"type" => "text");

							
		$options[] = array( "type" => "groupcontainerclose");											
														
	$options[] = array( "type" => "innertabclose");

	$options[] = array( "name" => "country10",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("Logo Section Settings", 'venom' ),
							"type" => "tabheading");
							
		$options[] = array( "name" => __("Logo Upload", 'venom' ),
							"type" => "groupcontaineropen");	
					
				$options[] = array( "name" => __("Upload Logo", 'venom' ),
										"desc" => __("Upload your logo here.", 'venom' ),
										"id" => "logo_layout_upload",
										"type" => "proupgrade",
										);														
										
		$options[] = array( "type" => "groupcontainerclose");							
		
		$options[] = array( "name" => __("Logo Section Layout", 'venom' ),
							"type" => "groupcontaineropen");	

					
				$options[] = array( "name" => __("Select a layout", 'venom' ),
										"desc" => __("Images for logo section.", 'venom' ),
										"id" => "logo_layout_style",
										"type" => "images",
										"std" => "onebone",
										"options" => array(
											'sbys' => $imagepath . 'logo1.png',
											'onebone' => $imagepath . 'logo2.png')
										);														

										
		$options[] = array( "type" => "groupcontainerclose");								
						
	$options[] = array( "type" => "innertabclose");	
	
	$options[] = array( "name" => "country3",
						"type" => "innertabopen");	

		$options[] = array( "name" => __("Select Header Type", 'venom' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Select which type of header", 'venom' ),
										"desc" => __("Header One or WordPress Custom header feature. If you select custom header, go to appearance->Header and set a custom header", 'venom' ),
										"id" => "header_slider",
										"std" => "one",
										"type" => "images",
										"std" => "one",
										"options" => array(
											'one' => $imagepath . 'slider1.png',
											'cheader' => $imagepath . 'slider2.png')
										);					

										
		$options[] = array( "type" => "groupcontainerclose");
		
		$options[] = array( "name" => __("Header's/Slider's Available in PRO Version", 'venom' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Following header's/slider's are available in PRO version", 'venom' ),
										"desc" => __("Upgrade to PRO version for above header's/Slider's", 'venom' ),
										"id" => "header_slider",
										"std" => "one",
										"type" => "proimages",
										"std" => "one",
										"options" => array(
											'one' => $imagepath . 'slider1.png',
											'videoone' => $imagepath . 'video.png',
											'oneplus' => $imagepath . 'oneplus.png',
											'slidertwo' => $imagepath . 'slidertwo.png',
											'slit' => $imagepath . 'slit.png',
											'fraction' => $imagepath . 'fraction.png',
											'hero' => $imagepath . 'hero.png')
										);					

										
		$options[] = array( "type" => "groupcontainerclose");		
		
		$options[] = array( "name" => __("Header On/Off Settings", 'venom' ),
							"type" => "groupcontaineropen");	

					
					$options[] = array( "name" => __("Show Header on homepage", 'venom' ),
										"desc" => __("Select yes if you want to show Header on homepage.", 'venom' ),
										"id" => "show_venom_slider_home",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);
										
					$options[] = array( "name" => __("Show Header on Single post page", 'venom' ),
										"desc" => __("Select yes if you want to show Header on Single post page.", 'venom' ),
										"id" => "show_venom_slider_single",
										"std" => "false",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show Header on Pages", 'venom' ),
										"desc" => __("Select yes if you want to show Header on Pages.", 'venom' ),
										"id" => "show_venom_slider_page",
										"std" => "false",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show Header on Category Pages", 'venom' ),
										"desc" => __("Select yes if you want to show Header on Category Pages.", 'venom' ),
										"id" => "show_venom_slider_archive",
										"std" => "false",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);																														
										
		$options[] = array( "type" => "groupcontainerclose");			
						
	$options[] = array( "type" => "innertabclose");	
	
	$options[] = array( "name" => "country6",
						"type" => "innertabopen");	

		$options[] = array( "name" => __("Slider One Settings", 'venom' ),
							"type" => "tabheading");
							
		$options[] = array( "name" => __("Slide 1", 'Venom' ),
							"type" => "groupcontaineropen");
							
					$options[] = array( "name" => __("Upload Image", 'Venom' ),
										"desc" => __("Upload your image here.", 'Venom' ),
										"id" => "slide_one_image",
										"type" => "upload");								

					$options[] = array( "name" => __("Headline", 'Venom' ),
										"desc" => __("Enter the headline", 'Venom' ),
										"id" => "slide_one_headline",
										"type" => "text");		
										
					$options[] = array( "name" => __("Feature text", 'Venom' ),
										"desc" => __("Enter the feature text", 'Venom' ),
										"id" => "slide_one_text",
										"type" => "text");
										
					$options[] = array( "name" => __("Link", 'Venom' ),
										"desc" => __("Enter the full url", 'Venom' ),
										"id" => "slide_one_cta_link",
										"type" => "text");																																	

										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Slide 2", 'Venom' ),
							"type" => "groupcontaineropen");
							
					$options[] = array( "name" => __("Upload Image", 'Venom' ),
										"desc" => __("Upload your image here.", 'Venom' ),
										"id" => "slide_two_image",
										"type" => "upload");								

					$options[] = array( "name" => __("Headline", 'Venom' ),
										"desc" => __("Enter the headline", 'Venom' ),
										"id" => "slide_two_headline",
										"type" => "text");		
										
					$options[] = array( "name" => __("Feature text", 'Venom' ),
										"desc" => __("Enter the feature text", 'Venom' ),
										"id" => "slide_two_text",
										"type" => "text");
										
					$options[] = array( "name" => __("Link", 'Venom' ),
										"desc" => __("Enter the full url", 'Venom' ),
										"id" => "slide_two_cta_link",
										"type" => "text");																																	

										
		$options[] = array( "type" => "groupcontainerclose");							
	
						
	$options[] = array( "type" => "innertabclose");	
	
								

	$options[] = array( "name" => "country4",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("Layout Settings", 'venom' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Select a homepage layout", 'venom' ),
										"desc" => __("Images for layout.", 'venom' ),
										"id" => "homepage_layout",
										"std" => "btwo",
										"type" => "images",
										"options" => array(
											'bone' => $imagepath . 'layout1.png',
											'btwo' => $imagepath . 'layout3.png',
											'spage' => $imagepath . 'layout2.png')
										);					

										
		$options[] = array( "type" => "groupcontainerclose");
		
		$options[] = array( "name" => __("Layouts available in PRO Version", 'venom' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Following layout's are available in PRO version", 'venom' ),
										"desc" => __("Upgrade to PRO version for above layouts", 'venom' ),
										"id" => "homepage_layout",
										"std" => "bone",
										"type" => "proimages",
										"options" => array(
											'bone' => $imagepath . 'layout1.png',
											'btwo' => $imagepath . 'layout3.png',
											'boneplus' => $imagepath . 'boneplus.png',
											'bthree' => $imagepath . 'bthree.png',
											'bfour' => $imagepath . 'bfour.png',
											'bfive' => $imagepath . 'bfive.png',
											'bsix' => $imagepath . 'bsix.png',
											'bseven' => $imagepath . 'bseven.png',
											'beight' => $imagepath . 'beight.png',
											'bnine' => $imagepath . 'bnine.png')
										);					

										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Quote Settings", 'venom' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Quote?", 'venom' ),
										"desc" => __("Enter the welcome text", 'venom' ),
										"id" => "show_quote",
										"type" => "proupgrade");	
										
					$options[] = array( "name" => __("Quote 1", 'venom' ),
										"desc" => __("Enter the quote text", 'venom' ),
										"id" => "show_quote1",
										"type" => "proupgrade");														

					$options[] = array( "name" => __("Customer 1", 'venom' ),
										"desc" => __("Enter the customer name", 'venom' ),
										"id" => "show_quote1_cust",
										"type" => "proupgrade");
										
					$options[] = array( "name" => __("Quote 2", 'venom' ),
										"desc" => __("Enter the quote text", 'venom' ),
										"id" => "show_quote2",
										"type" => "proupgrade");														

					$options[] = array( "name" => __("Customer 2", 'venom' ),
										"desc" => __("Enter the customer name", 'venom' ),
										"id" => "show_quote2_cust",
										"type" => "proupgrade");
										
					$options[] = array( "name" => __("Quote 3", 'venom' ),
										"desc" => __("Enter the quote text", 'venom' ),
										"id" => "show_quote3",
										"type" => "proupgrade");														

					$options[] = array( "name" => __("Customer 3", 'venom' ),
										"desc" => __("Enter the customer name", 'venom' ),
										"id" => "show_quote3_cust",
										"type" => "proupgrade");																				
										
		$options[] = array( "type" => "groupcontainerclose");
		
		$options[] = array( "name" => __("Client Logos", 'venom' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Client Logo Section?", 'venom' ),
										"desc" => __("Select yes if you want to show client logos.", 'venom' ),
										"id" => "show_quote",
										"type" => "proupgrade");	
										
					$options[] = array( "name" => __("Client Logo # 1", 'venom' ),
										"desc" => __("upload the logo", 'venom' ),
										"id" => "client_logo1",
										"type" => "proupgrade");														

					$options[] = array( "name" => __("Client Logo # 2", 'venom' ),
										"desc" => __("upload the logo", 'venom' ),
										"id" => "client_logo2",
										"type" => "proupgrade");
										
					$options[] = array( "name" => __("Client Logo # 3", 'venom' ),
										"desc" => __("upload the logo", 'venom' ),
										"id" => "client_logo3",
										"type" => "proupgrade");														

					$options[] = array( "name" => __("Client Logo # 4", 'venom' ),
										"desc" => __("upload the logo", 'venom' ),
										"id" => "client_logo4",
										"type" => "proupgrade");
										
		$options[] = array( "type" => "groupcontainerclose");							
						
	$options[] = array( "type" => "innertabclose");	
	
	$options[] = array( "name" => "country5",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("Biz One Settings", 'venom' ),
							"type" => "tabheading");
																							
						
		$options[] = array( "name" => __("Welcome Section", 'venom' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Headline", 'venom' ),
										"desc" => __("Enter the headline", 'venom' ),
										"id" => "welcome_headline",
										"type" => "textarea");		
										
					$options[] = array( "name" => __("Welcome text", 'venom' ),
										"desc" => __("Enter the welcome text", 'venom' ),
										"id" => "welcome_text",
										"type" => "textarea");														

										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Left Section", 'venom' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Upload Image", 'venom' ),
										"desc" => __("Upload your image here.", 'venom' ),
										"id" => "left_section_image",
										"type" => "upload");					
					
					$options[] = array( "name" => __("Headline", 'venom' ),
										"desc" => __("Enter the headline", 'venom' ),
										"id" => "left_section_headline",
										"type" => "textarea");		
										
					$options[] = array( "name" => __("Welcome text", 'venom' ),
										"desc" => __("Enter the welcome text", 'venom' ),
										"id" => "left_section_text",
										"type" => "textarea");
										
					$options[] = array( "name" => __("Link", 'venom' ),
										"desc" => __("Enter the link to product or service", 'venom' ),
										"id" => "left_section_link",
										"type" => "text");																							

										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Center Section", 'venom' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Upload Image", 'venom' ),
										"desc" => __("Upload your image here.", 'venom' ),
										"id" => "center_section_image",
										"type" => "upload");					
					
					$options[] = array( "name" => __("Headline", 'venom' ),
										"desc" => __("Enter the headline", 'venom' ),
										"id" => "center_section_headline",
										"type" => "textarea");		
										
					$options[] = array( "name" => __("Welcome text", 'venom' ),
										"desc" => __("Enter the welcome text", 'venom' ),
										"id" => "center_section_text",
										"type" => "textarea");	
										
					$options[] = array( "name" => __("Link", 'venom' ),
										"desc" => __("Enter the link to product or service", 'venom' ),
										"id" => "center_section_link",
										"type" => "text");																							

										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Right Section", 'venom' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Upload Image", 'venom' ),
										"desc" => __("Upload your image here.", 'venom' ),
										"id" => "right_section_image",
										"type" => "upload");					
					
					$options[] = array( "name" => __("Headline", 'venom' ),
										"desc" => __("Enter the headline", 'venom' ),
										"id" => "right_section_headline",
										"type" => "textarea");		
										
					$options[] = array( "name" => __("Welcome text", 'venom' ),
										"desc" => __("Enter the welcome text", 'venom' ),
										"id" => "right_section_text",
										"type" => "textarea");
										
					$options[] = array( "name" => __("Link", 'venom' ),
										"desc" => __("Enter the link to product or service", 'venom' ),
										"id" => "right_section_link",
										"type" => "text");																								

										
		$options[] = array( "type" => "groupcontainerclose");
		
		$options[] = array( "name" => __("Quote Section", 'venom' ),
							"type" => "groupcontaineropen");
							
					$options[] = array( "name" => __("Show Quote?", 'venom' ),
										"desc" => __("Select yes if you want to show quote.", 'venom' ),
										"id" => "show_venom_quote_bizone",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);								
					
					$options[] = array( "name" => __("Quote", 'venom' ),
										"desc" => __("Enter the Quote Text", 'venom' ),
										"id" => "quote_section_text",
										"type" => "textarea");		
										
					$options[] = array( "name" => __("Customer Name", 'venom' ),
										"desc" => __("Enter the customer name", 'venom' ),
										"id" => "quote_section_name",
										"type" => "text");														

										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Recent Posts", 'venom' ),
							"type" => "groupcontaineropen");
														
					$options[] = array( "name" => __("Show Recent Posts Section?", 'venom' ),
										"desc" => __("Select yes if you want to recent posts at the bottom.", 'venom' ),
										"id" => "show_bizone_posts",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);	
										
		$options[] = array( "type" => "groupcontainerclose");														
						
	$options[] = array( "type" => "innertabclose");
	
	$options[] = array( "name" => "country7",
						"type" => "innertabopen");
						

		$options[] = array( "name" => __("Biz Four Settings", 'venom' ),
							"type" => "tabheading");						
						
		$options[] = array( "name" => __("Welcome Section", 'venom' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Headline", 'venom' ),
										"desc" => __("Enter the headline", 'venom' ),
										"id" => "biztwo_welcome_headline",
										"type" => "textarea");		
										
					$options[] = array( "name" => __("Welcome text", 'venom' ),
										"desc" => __("Enter the welcome text", 'venom' ),
										"id" => "biztwo_welcome_text",
										"type" => "textarea");														

										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Left Section", 'venom' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Upload Image", 'venom' ),
										"desc" => __("Upload your image here.", 'venom' ),
										"id" => "biztwo_left_section_image",
										"type" => "upload");					
					
					$options[] = array( "name" => __("Name", 'venom' ),
										"desc" => __("Enter the name of product or service", 'venom' ),
										"id" => "biztwo_left_section_headline",
										"type" => "textarea");		
										
					$options[] = array( "name" => __("Description", 'venom' ),
										"desc" => __("Enter the description of product or service", 'venom' ),
										"id" => "biztwo_left_section_text",
										"type" => "textarea");	
										
					$options[] = array( "name" => __("Link", 'venom' ),
										"desc" => __("Enter the link to product or service", 'venom' ),
										"id" => "biztwo_left_section_link",
										"type" => "text");																							

										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Center Left Section", 'venom' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Upload Image", 'venom' ),
										"desc" => __("Upload your image here.", 'venom' ),
										"id" => "biztwo_center_section_image",
										"type" => "upload");					
					
					$options[] = array( "name" => __("Name", 'venom' ),
										"desc" => __("Enter the name of product or service", 'venom' ),
										"id" => "biztwo_center_section_headline",
										"type" => "textarea");		
										
					$options[] = array( "name" => __("Description", 'venom' ),
										"desc" => __("Enter the description of product or service", 'venom' ),
										"id" => "biztwo_center_section_text",
										"type" => "textarea");	
										
					$options[] = array( "name" => __("Link", 'venom' ),
										"desc" => __("Enter the link to product or service", 'venom' ),
										"id" => "biztwo_center_section_link",
										"type" => "text");																							

										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Center Right Section", 'venom' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Upload Image", 'venom' ),
										"desc" => __("Upload your image here.", 'venom' ),
										"id" => "biztwo_centerright_section_image",
										"type" => "upload");					
					
					$options[] = array( "name" => __("Name", 'venom' ),
										"desc" => __("Enter the name of product or service", 'venom' ),
										"id" => "biztwo_centerright_section_headline",
										"type" => "textarea");		
										
					$options[] = array( "name" => __("Description", 'venom' ),
										"desc" => __("Enter the description of product or service", 'venom' ),
										"id" => "biztwo_centerright_section_text",
										"type" => "textarea");
										
					$options[] = array( "name" => __("Link", 'venom' ),
										"desc" => __("Enter the link to product or service", 'venom' ),
										"id" => "biztwo_centerright_section_link",
										"type" => "text");																								

										
		$options[] = array( "type" => "groupcontainerclose");			
		
		$options[] = array( "name" => __("Right Section", 'venom' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Upload Image", 'venom' ),
										"desc" => __("Upload your image here.", 'venom' ),
										"id" => "biztwo_right_section_image",
										"type" => "upload");					
					
					$options[] = array( "name" => __("Name", 'venom' ),
										"desc" => __("Enter the name of product or service", 'venom' ),
										"id" => "biztwo_right_section_headline",
										"type" => "textarea");		
										
					$options[] = array( "name" => __("Description", 'venom' ),
										"desc" => __("Enter the description of product or service", 'venom' ),
										"id" => "biztwo_right_section_text",
										"type" => "textarea");
										
					$options[] = array( "name" => __("Link", 'venom' ),
										"desc" => __("Enter the link to product or service", 'venom' ),
										"id" => "biztwo_right_section_link",
										"type" => "text");																								

										
		$options[] = array( "type" => "groupcontainerclose");
		
		$options[] = array( "name" => __("Quote Section", 'venom' ),
							"type" => "groupcontaineropen");	
							
					$options[] = array( "name" => __("Show Quote?", 'venom' ),
										"desc" => __("Select yes if you want to show quote.", 'venom' ),
										"id" => "show_venom_quote_biztwo",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);								
					
					$options[] = array( "name" => __("Quote", 'venom' ),
										"desc" => __("Enter the Text", 'venom' ),
										"id" => "biztwo_quote_section_text",
										"type" => "textarea");		
										
					$options[] = array( "name" => __("Name", 'venom' ),
										"desc" => __("Enter the name", 'venom' ),
										"id" => "biztwo_quote_section_name",
										"type" => "text");														

										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Recent Posts", 'venom' ),
							"type" => "groupcontaineropen");
														
					$options[] = array( "name" => __("Show Recent Posts Section?", 'venom' ),
										"desc" => __("Select yes if you want to recent posts at the bottom.", 'venom' ),
										"id" => "show_biztwo_posts",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);	
										
		$options[] = array( "type" => "groupcontainerclose");																						
						
	$options[] = array( "type" => "innertabclose");			
	
	$options[] = array( "name" => "country9",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("Standard Page Settings", 'venom' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Comments?", 'venom' ),
										"desc" => __("Select yes if you want to show comments", 'venom' ),
										"id" => "show_comments_spage",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);		
										
		$options[] = array( "type" => "groupcontainerclose");								
						
	$options[] = array( "type" => "innertabclose");	

	$options[] = array( "name" => "country19",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("Layouts available in PRO Version", 'venom' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Portfolio layout's are available in PRO version", 'venom' ),
										"desc" => __("Upgrade to PRO version for above layouts", 'venom' ),
										"id" => "portfolio_layout",
										"std" => "pone",
										"type" => "proimages",
										"options" => array(
											'pone' => $imagepath . 'pone.png',
											'ptwo' => $imagepath . 'ptwo.png',
											'pthree' => $imagepath . 'pthree.png',
											'pfour' => $imagepath . 'pfour.png')
										);					

										
		$options[] = array( "type" => "groupcontainerclose");						
						
	$options[] = array( "type" => "innertabclose");
								
	$options[] = array( "name" => "country11",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("Footer Settings", 'venom' ),
							"type" => "tabheading");
							
		$options[] = array( "name" => __("Social Section", 'venom' ),
							"type" => "groupcontaineropen");	
					
				$options[] = array( "name" => __("Show social Section?", 'venom' ),
										"desc" => __("Select yes if you want to show social section.", 'venom' ),
										"id" => "show_social_section",
										"type" => "proupgrade",
										);														
										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Footer Logo Upload", 'venom' ),
							"type" => "groupcontaineropen");	
					
				$options[] = array( "name" => __("Upload Logo", 'venom' ),
										"desc" => __("Upload your logo here.", 'venom' ),
										"id" => "footer_logo_upload",
										"type" => "proupgrade",
										);														
										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Address Settings", 'venom' ),
							"type" => "groupcontaineropen");	
					
				$options[] = array( "name" => __("Show Search?", 'venom' ),
										"desc" => __("Select yes if you want to show search.", 'venom' ),
										"id" => "show_foote_search",
										"type" => "proupgrade",
										);	
										
				$options[] = array( "name" => __("Address", 'venom' ),
										"desc" => __("Enter Address", 'venom' ),
										"id" => "footer_address",
										"type" => "proupgrade",
										);	
										
				$options[] = array( "name" => __("Email", 'venom' ),
										"desc" => __("Enter Email Address", 'venom' ),
										"id" => "footer_email_address",
										"type" => "proupgrade",
										);
										
				$options[] = array( "name" => __("Phone Number", 'venom' ),
										"desc" => __("Enter Phone Number", 'venom' ),
										"id" => "footer_phone",
										"type" => "proupgrade",
										);
										
				$options[] = array( "name" => __("Skype", 'venom' ),
										"desc" => __("Enter Skype Address", 'venom' ),
										"id" => "footer_skype_address",
										"type" => "proupgrade",
										);
										
				$options[] = array( "name" => __("Google Map", 'venom' ),
										"desc" => __("Enter google map", 'venom' ),
										"id" => "footer_map_address",
										"type" => "proupgrade",
										);																																																														
										
		$options[] = array( "type" => "groupcontainerclose");											
										
		$options[] = array( "name" => __("Footer Layouts", 'venom' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Select a footer layout", 'venom' ),
										"desc" => __("Images for layout.", 'venom' ),
										"id" => "footer_layout",
										"std" => "one",
										"type" => "images",
										"std" => "one",
										"options" => array(
											'one' => $imagepath . 'footer1.png',
											'two' => $imagepath . 'footer2.png')
										);	
										
		$options[] = array( "type" => "groupcontainerclose");
		
		$options[] = array( "name" => __("Footer Layouts available in PRO Version", 'venom' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Following layout's are available in PRO version", 'venom' ),
										"desc" => __("Upgrade to PRO version for above layouts", 'venom' ),
										"id" => "homepage_layout",
										"std" => "fone",
										"type" => "proimages",
										"options" => array(
											'fthree' => $imagepath . 'fthree.png',
											'ffour' => $imagepath . 'ffour.png',
											'ffive' => $imagepath . 'ffive.png',
											'fsix' => $imagepath . 'fsix.png')
										);					
										
		$options[] = array( "type" => "groupcontainerclose");																							
						
	$options[] = array( "type" => "innertabclose");			
							
						

							
		
	return $options;
}