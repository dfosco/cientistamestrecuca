<?php
    function zephyr_get_default_options() {
        $options = array(
            'socials' => '',
            'twitter_key' => '',
            'twitter_secret' => '',
            'facebook_token' => ''
        );
        return $options;
    }
    function zephyr_social_init() {
        $zephyr_options = get_option( 'theme_zephyr_options' );
        // Are our options saved in the DB?
        if ( false === $zephyr_options ) {
            // If not, we'll save our default options
            $zephyr_options = zephyr_get_default_options();
            add_option( 'theme_zephyr_options', $zephyr_options );
        }
        $zephyr_ads = get_option( 'theme_zephyr_ads' );
        // Are our options saved in the DB?
        if ( false === $zephyr_ads ) {
            // If not, we'll save our default options
            $zephyr_ads = Array(
            	'adsafter' => '',
            	'postscount' => '5',
            	'adssidebar' => '',
            	'sidecount' => '5',
            );
            add_option( 'theme_zephyr_ads', $zephyr_ads );
        }
		$zephyr_optin = get_option( 'zephyr_optin_options' );
        if ( false === $zephyr_optin ) {
			$default_optin = Array(
					'optinimage' => '',
					'optin_enable' => '0',
					'optinfile' => '',
					'optindelay' => '5',
					'optinhide' => '0',
					'optinsubject' => __('Thank you for your interest in our e-book!', 'zephyr'),
					'optinmessage' => __('Hi there! Thank you for your interest in our e-book!', 'zephyr'),
					'optinbutton' => __('SEND IT TO ME!', 'zephyr')
			);
			add_option( 'zephyr_optin_options', $default_optin );
        }
        $optinmails = get_option( 'zephyr_optin_emails' );
        if ( false === $optinmails ) {
        	$optinmails = Array(
        		Array('Name', 'Email')
        	);
        	add_option( 'zephyr_optin_emails', $optinmails );
        }
    }
    // Initialize Theme options
    add_action( 'after_setup_theme', 'zephyr_social_init' );
    
    function zephyr_menu_options() {
        add_theme_page('Social Options', 'Social Options', 'edit_theme_options', 'zephyr-social', 'zephyr_admin_social_page');
        add_menu_page('Advertising', 'Advertising', 'edit_theme_options', 'zephyr-ads' );
        add_submenu_page('zephyr-ads', 'Ads Options', 'Ads', 'edit_theme_options', 'zephyr-ads', 'zephyr_admin_ads_page' );
        add_submenu_page('zephyr-ads', 'Opt-in Pop-up Options', 'Opt-in Pop-up', 'edit_theme_options', 'zephyr-optin', 'zephyr_optin_page' );
    }
    add_action('admin_menu', 'zephyr_menu_options');
    
//     include the Opt-in options panel
    include_once('zephyr-optin.php');
    
    function zephyr_admin_social_page() {  
        ?>       
            <div class="wrap">  
                <div id="icon-themes" class="icon32"><br /></div>  
                <h2><?php _e( 'Zephyr Options', 'zephyr' ); ?></h2>        
                <!-- If we have any error by submiting the form, they will appear here -->  
                <?php settings_errors( 'zephyr-settings-errors' ); ?>        
                <form id="form-zephyr-social" action="options.php" method="post" enctype="multipart/form-data">  
                    <?php  
                        settings_fields('theme_zephyr_options');  
                        do_settings_sections('zephyr');  
                    ?>  
                    <p class="submit">  
                        <input name="theme_zephyr_options[submit]" id="submit_options_form" type="submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'zephyr'); ?>" />  
                    </p>
                </form>
            </div>  
        <?php  
    }  
    function zephyr_settings_init() {  
        register_setting( 'theme_zephyr_options', 'theme_zephyr_options', 'zephyr_options_validate' );
        register_setting( 'theme_zephyr_ads', 'theme_zephyr_ads', 'zephyr_ads_validate' );
        register_setting( 'zephyr_optin_options', 'zephyr_optin_options', 'zephyr_optin_validate' );
       	
        add_settings_section('zephyr_settings_header', __( 'Social Profiles', 'zephyr' ), 'zephyr_settings_header_text', 'zephyr');
        add_settings_section('zephyr_settings_twitter', __( 'Twitter Feed settings', 'zephyr' ), 'zephyr_settings_twitter_text', 'zephyr');
        add_settings_section('zephyr_settings_facebook', __( 'Facebook Feed settings', 'zephyr' ), 'zephyr_settings_facebook_text', 'zephyr');
      
        add_settings_field('zephyr_socials',  __( 'Social Profiles', 'zephyr' ), 'zephyr_icon_selector', 'zephyr', 'zephyr_settings_header', array( 'name' => 'socials' ));
        
        add_settings_field('zephyr_twitter_key',  __( 'Consumer Key', 'zephyr' ), 'zephyr_text_input', 'zephyr', 'zephyr_settings_twitter', array( 'name' => 'twitter_key' ));
        add_settings_field('zephyr_twitter_secret',  __( 'Consumer secret', 'zephyr' ), 'zephyr_text_input', 'zephyr', 'zephyr_settings_twitter', array( 'name' => 'twitter_secret' ));
        		
        add_settings_field('zephyr_facebook_token',  __( 'App token', 'zephyr' ), 'zephyr_text_input', 'zephyr', 'zephyr_settings_facebook', array( 'name' => 'facebook_token' ));
        
        // add ads options
        add_settings_section('zephyr_ads_header', __( 'Ads Options', 'zephyr' ), 'zephyr_ads_header_text', 'zephyr-ads');
		add_settings_field('zephyr_adsafter',  __( 'Ads after posts Code', 'zephyr' ), 'zephyr_textarea', 'zephyr-ads', 'zephyr_ads_header', array( 'name' => 'adsafter' ));
       	add_settings_field('zephyr_postscount',  __( 'Display ads after how many posts?', 'zephyr' ), 'zephyr_input_small', 'zephyr-ads', 'zephyr_ads_header', array( 'name' => 'postscount' ));
		add_settings_field('zephyr_adssidebar',  __( 'Ads in sidebar', 'zephyr' ), 'zephyr_textarea', 'zephyr-ads', 'zephyr_ads_header', array( 'name' => 'adssidebar' ));
       	add_settings_field('zephyr_sidecount',  __( 'Display ads after how many sidebar posts?', 'zephyr' ), 'zephyr_input_small', 'zephyr-ads', 'zephyr_ads_header', array( 'name' => 'sidecount' ));
    
    	// add Opt-in options
        add_settings_section('zephyr_optin_header', __( 'Pop-up options', 'zephyr' ), '', 'zephyr_optin');
		add_settings_field('zephyr_optin_enable',  __( 'Enable opt-in pop-up?', 'zephyr' ), 'zephyr_optininput', 'zephyr_optin', 'zephyr_optin_header', array( 'name' => 'optin_enable', 'type' => 'checkbox' ));
		add_settings_field('zephyr_optinimage',  __( 'Optin image', 'zephyr' ), 'zephyr_optininput', 'zephyr_optin', 'zephyr_optin_header', array( 'name' => 'optinimage', 'type' => 'upload' ));
		add_settings_field('zephyr_optinfile',  __( 'File to send', 'zephyr' ), 'zephyr_optininput', 'zephyr_optin', 'zephyr_optin_header', array( 'name' => 'optinfile','type' => 'upload' , 'button' => __('Choose File', 'zehpyr') , 'desc' => 'This file will be attached to the e-mail the user receives' ));
		add_settings_field('zephyr_optin_delay',  __( 'Optin delay', 'zephyr' ), 'zephyr_optininput', 'zephyr_optin', 'zephyr_optin_header', array( 'name' => 'optindelay' , 'desc' => __('Number of seconds to delay the pop-up after the page has loaded', 'zephyr')));
		add_settings_field('zephyr_optin_hide',  __( 'Optin hide', 'zephyr' ), 'zephyr_optininput', 'zephyr_optin', 'zephyr_optin_header', array( 'name' => 'optinhide', 'desc' => __('Number of days to hide the pop-up if the user closed it ( 0 means show each time )', 'zephyr') ));
		add_settings_field('zephyr_optin_subject',  __( 'Mail subject', 'zephyr' ), 'zephyr_optininput', 'zephyr_optin', 'zephyr_optin_header', array( 'name' => 'optinsubject' , 'desc' => __('The subject for the email sent to the user', 'zephyr')));
		add_settings_field('zephyr_optin_message',  __( 'Mail subject', 'zephyr' ), 'zephyr_optininput', 'zephyr_optin', 'zephyr_optin_header', array( 'name' => 'optinmessage' , 'desc' => __('The message that the user will receive', 'zephyr'), 'type' => 'textarea' ));
		add_settings_field('zephyr_optin_button',  __( 'Button text', 'zephyr' ), 'zephyr_optininput', 'zephyr_optin', 'zephyr_optin_header', array( 'name' => 'optinbutton' , 'desc' => __('The text of the submit button', 'zephyr') ));
		
    }  
    add_action( 'admin_init', 'zephyr_settings_init' );  

    function zephyr_settings_header_text() {  
        ?>  
            <p><?php _e( 'Insert the link to your social profile and choose an icon to display it, click add new and save it.', 'zephyr' ); ?></p>  
        <?php  
    }
    function zephyr_ads_header_text() {  
        ?>  
            <p><?php _e( 'Use this area to define ads & ad placement. The template is optimized for Google Adsense ads and we recommend using the "Responsive" size when creating the ad but it should work just fine with similar types of ads.', 'zephyr' ); ?></p>  
        <?php  
    }
    function zephyr_settings_twitter_text() {
        ?>
            <p><strong><?php _e( 'Directions to get the Consumer Key and Consumer Secret', 'zephyr' ); ?></strong></p>
            <ol>
				<li><a href="https://dev.twitter.com/apps/new" target="_blank"><?php _e( 'Add a new Twitter application', 'zephyr' ); ?></a></li>
				<li><?php _e( 'Fill in Name, Description, Website, and Callback URL (don\'t leave any blank) with anything you want', 'zephyr' ); ?></li>
				<li><?php _e( 'Agree to rules, fill out captcha, and submit your application', 'zephyr' ); ?></li>
				<li><?php _e( 'Click on "OAuth tool" to change to that tab', 'zephyr' ); ?></li>
				<li><?php _e( 'Copy the Consumer key and Consumer secret into the fields below', 'zephyr' ); ?></li>
				<li><?php _e( 'Click the Save settings button at the bottom of this page', 'zephyr' ); ?></li>
            </ol>
        <?php
    }
    function zephyr_settings_facebook_text() {
        ?>
            <p><strong><?php _e( 'Directions to get the App token', 'zephyr' ); ?></strong></p>
            <ol>
				<li><a href="https://developers.facebook.com/" target="_blank"><?php _e( 'Go to developers.facebook.com', 'zephyr' ); ?></a></li>
				<li><?php _e( 'Log in using your PERSONAL Facebook credentials', 'zephyr' ); ?></li>
				<li><?php _e( 'If you don\'t have a developer account, click on "Register now"', 'zephyr' ); ?></li>
				<li><?php _e( 'Accept the terms and click on "Continue"', 'zephyr' ); ?></li>
				<li><?php _e( 'Confirm your account and click Continue', 'zephyr' ); ?></li>
				<li><?php _e( 'Fill in info about yourself (optional)', 'zephyr' ); ?></li>
				<li><?php _e( 'Click "Done"', 'zephyr' ); ?></li>
				<li><?php _e( 'Click on "Apps" > "Create a New App"', 'zephyr' ); ?></li>
				<li><?php _e( 'Fill in App name with whatever you want, select a Category and click "Continue"', 'zephyr' ); ?></li>
				<li><?php _e( 'Fill in the Captcha and click "Continue"', 'zephyr' ); ?></li>
				<li><?php _e( 'Navigate to ', 'zephyr' ); ?><a href="https://developers.facebook.com/tools/access_token/" target="_blank">https://developers.facebook.com/tools/access_token/</a></li>
				<li><?php _e( 'In the list there find the app you just created and copy/paste the App token into the field below.', 'zephyr' ); ?></li>
            </ol>
        <?php
    }

    function zephyr_text_input( array $args ) {
    	$defaults = array('name' => '', 'desc' => '');
    	$args = array_merge($defaults, $args);
        $zephyr_options = get_option( 'theme_zephyr_options' );
        $name = $args['name'];
        $val = $zephyr_options[$name];
        $desc = $args['desc'];
        echo "<input type='text' id='{$name}' name='theme_zephyr_options[{$name}]' value='{$val}' />";
        echo "<span class='description'>{$desc}</span>";
    }
    
    function zephyr_input_small( array $args ) {
    	$defaults = array('name' => '', 'desc' => '');
    	$args = array_merge($defaults, $args);
        $zephyr_options = get_option( 'theme_zephyr_ads' );
        $name = $args['name'];
        $val = $zephyr_options[$name];
        $desc = $args['desc'];
        echo "<input type='text' size='3' id='{$name}' name='theme_zephyr_ads[{$name}]' value='{$val}' />";
        echo "<span class='description'>{$desc}</span>";    
    }

	function zephyr_textarea( array $args ) {
    	$defaults = array('name' => '', 'desc' => '');
    	$args = array_merge($defaults, $args);
        $zephyr_options = get_option( 'theme_zephyr_ads' );
        $name = $args['name'];
        $val = $zephyr_options[$name];
        $desc = $args['desc'];
        echo "<textarea cols='65' rows='12' name='theme_zephyr_ads[{$name}]'>{$val}</textarea>";	
	}

	function zephyr_ads_validate( $input ) {
		$default_options = Array(
            	'adsafter' => '',
            	'postscount' => '5',
            	'adssidebar' => ''
		);
		$valid_input = $default_options;  
	  	
		$zephyr_options = get_option('theme_zephyr_ads');
		$submit = ! empty($input['submit']) ? true : false;
		
		unset($input['submit']);
		if ( $submit ) {
			foreach( $input as $key => $value ) {
					$valid_input[$key] = $input[$key];
			}
		}
	  
		return $valid_input;  
	}

    function zephyr_options_validate( $input ) {  
		$default_options = zephyr_get_default_options();  
		$valid_input = $default_options;  
	  	
		$zephyr_options = get_option('theme_zephyr_options');  
	  
		$submit = ! empty($input['submit']) ? true : false;
		// validate socials separately
		$socials = Array();
		if ( array_key_exists('socials', $input) ) {
			foreach($input['socials'] as $social) {
				$social = explode(',', $social);
				$newsocial = Array(
					'link' => esc_url($social[0]),
					'image' => $social[1]
				);
				$socials[] = $newsocial;
			}
			$valid_input['socials'] = json_encode($socials);
		}
		unset($input['socials']);
		unset($input['submit']);
		if ( $submit ) {
			foreach( $input as $key => $value ) {
					$valid_input[$key] = strip_tags($input[$key]);
			}
		}
	  
		return $valid_input;  
    }

	function zephyr_icon_selector( array $args ) {
		$options = '';
		$folder = get_template_directory_uri().'/img/social-icons';
		if ($handle = opendir(get_stylesheet_directory().'/img/social-icons')) {
			while (false !== ($entries[] = readdir($handle)));
			sort($entries);
			foreach($entries as $entry) {
				if ($entry != "." && $entry != ".." && $entry != "") {
					$options .= "<option value='$entry' data-imagesrc='$folder/$entry'>$entry</option>";
				}
			}
			closedir($handle);
		}
    	$defaults = array('name' => '', 'desc' => '');
    	$args = array_merge($defaults, $args);
        $zephyr_options = get_option( 'theme_zephyr_options' );
        echo "<input type='text' id='zsociallink' value='' />";
        echo "<select data-selectText=".__('Choose an icon', 'zephyr')." id='ddslick' name='zsocial'>$options</select>";
        echo "<a href='#' class='zephyr-social-input'>Add new</a>";
        echo '<div id="socialrows">';
        if ( array_key_exists('socials', $zephyr_options ) ) {
			$old = json_decode($zephyr_options['socials'], true);
			if ( is_array($old) ) {
				foreach( $old as $show ) {
					echo '<div class="socialrow"><div class="socials-list"><img src="'.$show['image'].'" /><span> - '.$show['link'].'</span> <a href="#" class="remove-social">Remove</a></div>';
					echo '<input type="hidden" value="'.$show['link'].','.$show['image'].'" name="theme_zephyr_options[socials][]" /></div>';
				}
			}
		}
        echo '</div>';
	}

    function zephyr_admin_ads_page() {  
        ?>       
            <div class="wrap">  
                <div id="icon-themes" class="icon32"><br /></div>  
                <h2><?php _e( 'Zephyr Ads Placement', 'zephyr' ); ?></h2>        
                <!-- If we have any error by submiting the form, they will appear here -->  
                <?php settings_errors( 'zephyr-settings-errors' ); ?>        
                <form id="form-zephyr-ads" action="options.php" method="post" enctype="multipart/form-data">  
                    <?php  
                        settings_fields('theme_zephyr_ads');  
                        do_settings_sections('zephyr-ads');  
                    ?>  
                    <p class="submit">  
                        <input name="theme_zephyr_ads[submit]" id="submit_options_form" type="submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'zephyr'); ?>" />  
                    </p>
                </form>
            </div>  
        <?php  
    }  
?>