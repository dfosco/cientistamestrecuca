<?php
// Opt-in download pop-up

    function zephyr_optin_page() {
        ?>       
            <div class="wrap">  
                <div id="icon-themes" class="icon32"><br /></div>  
                <h2><?php _e( 'Opt-in Pop-up Options', 'zephyr' ); ?></h2>        
                <?php settings_errors( 'zephyr-settings-errors' ); ?>        
                <form id="form-zephyr-optin" action="options.php" method="post" enctype="multipart/form-data">  
                    <?php  
                        settings_fields('zephyr_optin_options');  
                        do_settings_sections('zephyr_optin');  
                    ?>  
                    <p class="submit">  
                        <input name="zephyr_optin_options[submit]" id="submit_options_form" type="submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'zephyr'); ?>" />  
                    </p>
                </form>
                
                <h2><?php _e( 'Collected E-mails', 'zephyr' ); ?></h2>
                <?php $optinmails = get_option( 'zephyr_optin_emails' );
                	if ( !empty ( $optinmails ) ) {
                		$_SESSION['zephyr_optinmails'] = $optinmails;
                		echo '<a class="button add_media" href="'.get_template_directory_uri().'/zephyr-admin/downloadcsv.php" target="_blank">Download Emails CSV</a>';
					}
                ?>
            </div>  
        <?php  
    }

	add_action('init', 'zephyr_start_session', 1);
	add_action('wp_logout', 'zephyr_end_session');
	add_action('wp_login', 'zephyr_end_session');

	function zephyr_start_session() {
		if(!session_id()) {
			session_start();
		}
	}

	function zephyr_end_session() {
		session_destroy ();
	}

    function zephyr_optininput($args) {
    	$defaults = array('name' => '', 'desc' => '', 'type' => 'text', 'button' => __('Choose Image', 'zehpyr'), 'desc' => '' );
    	$args = array_merge($defaults, $args);
        $zephyr_options = get_option( 'zephyr_optin_options' );
        $name = $args['name'];
        $val = $zephyr_options[$name];
        $desc = $args['desc'];
        if ( $args['type'] == 'checkbox' ) {
        	echo "<input type='checkbox' id='{$name}' name='zephyr_optin_options[{$name}]' value='1' ".checked($val, 1, false)." />"; 
        } elseif( $args['type'] == 'textarea' ) {
        	echo "<textarea cols='50' rows='10' id='{$name}' name='zephyr_optin_options[{$name}]'>{$val}</textarea>"; 
        }else {
			echo "<input type='text' id='{$name}' name='zephyr_optin_options[{$name}]' value='{$val}' />"; 
			if ($args['type'] == 'upload' ) {
			?>
			<div class="wp-media-buttons"><a title="<?php _e('Choose image', 'zephyr'); ?>" data-uploader_title="<?php _e('Opt-in', 'zephyr'); ?>" data-uploader_button_text="<?php _e('Select File', 'zephyr'); ?>" class="upload_image_button button add_media" data-image_target="#<?php echo $name; ?>" id="" href="#"><span class="wp-media-buttons-icon"></span> <?php echo $args['button'] ?></a>
			<?php }
		}
		echo '<br /><span class="description">'. $args['desc'] . '</span>';
    }
    function zephyr_optin_validate($input) {
		$default_options = Array(
            	'optinimage' => '',
            	'optin_enable' => '0',
            	'optinfile' => '',
            	'optindelay' => '5',
            	'optinhide' => '0',
            	'optinsubject' => __('Thank you for your interest in our e-book!', 'zephyr'),
            	'optinmessage' => __('Hi there! Thank you for your interest in our e-book!', 'zephyr'),
            	'optinbutton' => __('SEND IT TO ME!', 'zephyr')
		);
		$valid_input = $default_options;  
	  	
		$zephyr_options = get_option('zephyr_optin_options');
		$submit = ! empty($input['submit']) ? true : false;
		
		unset($input['submit']);
		if ( $submit ) {
			foreach( $input as $key => $value ) {
				if ( $input[$key] !== '' ) {
					$valid_input[$key] = $input[$key];
				}
			}
		}
	  
		return $valid_input; 
    }
?>