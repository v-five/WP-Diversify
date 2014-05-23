    <div id="feature" class="site-slider">
    
                             <div class="cycle-slideshow" 
                                data-cycle-fx=scrollHorz
                                data-cycle-timeout=10000
                                data-cycle-paused=true
                                data-cycle-overlay-template='<div class="slider-cycle-caption-container">
                                                	
                                                        <h2><a href="{{link}}">{{title}}</a></h2>
                                                        <p>{{desc}}</p>
                                                    
                                                </div>'>
                                <!-- empty element for overlay -->
                                <div class="cycle-overlay"></div>
                                
                                <div class="cycle-pager"></div>
                            
                                <img src="
									<?php 
                                        if( of_get_option('slide_one_image') ){
                                            echo esc_url( of_get_option('slide_one_image') );
                                        }else {
                                            echo get_stylesheet_directory_uri().'/images/slide1.png';
                                        }
                                    ?> 								
                                " 
                                    data-cycle-title="
										<?php 
                                            if( of_get_option('slide_one_headline') ){
                                                echo esc_html( of_get_option('slide_one_headline') );
                                            }else {
												_e('Responsive Business Theme',  'Venom');
                                            }
                                        ?>                                    
                                    " 
                                    data-cycle-desc="
										<?php 
                                            if( of_get_option('slide_one_text') ){
                                                echo esc_html( of_get_option('slide_one_text') );
                                            }else {
												_e('You can change text for slide 1 in Slider One settings tab of theme options page. Write something awesome to make your website ridiculously fabulous.',  'Venom');
                                            }
                                        ?>                                     
                                    "
                                    data-cycle-link="
										<?php if( of_get_option('slide_one_cta_link') ){ echo esc_url( of_get_option('slide_one_cta_link') );}else { echo '#';}?>                                    
                                    ">
                            
                                <img src="
									<?php 
                                        if( of_get_option('slide_two_image') ){
                                            echo esc_url( of_get_option('slide_two_image') );
                                        }else {
                                            echo get_stylesheet_directory_uri().'/images/slide2.jpg';
                                        }
                                    ?> 								
                                " 
                                    data-cycle-title="
										<?php 
                                            if( of_get_option('slide_two_headline') ){
                                                echo esc_html( of_get_option('slide_two_headline') );
                                            }else {
												_e('Multiple Layouts',  'Venom');
                                            }
                                        ?>                                    
                                    " 
                                    data-cycle-desc="
										<?php 
                                            if( of_get_option('slide_two_text') ){
                                                echo esc_html( of_get_option('slide_two_text') );
                                            }else {
												_e('You can change text for slide 2 in Slider One settings tab of theme options page. Write something awesome to make your website ridiculously fabulous.',  'Venom');
                                            }
                                        ?>                                     
                                    "
                                    data-cycle-link="
										<?php if( of_get_option('slide_two_cta_link') ){ echo esc_url( of_get_option('slide_two_cta_link') );}else { echo '#';}?>                                    
                                    ">

                            </div>          
    
    </div><!-- #banner -->