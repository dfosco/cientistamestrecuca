<?php
function zephyr_customize_register( $wp_customize ) {

	// Allow .ico image upload for favicon option

	class Zephyr_Favicon_Control extends WP_Customize_Image_Control {
		public function __construct( $manager, $id, $args ) {
			$this->extensions[] = 'ico';
			return parent::__construct( $manager, $id, $args );
		}
	}

	// Add new custom control for google font picker

	class Zephyr_GFont_Picker extends WP_Customize_Control {
		public $type = 'gfontpicker';
		public $statuses;
	public function __construct( $manager, $id, $args = array() ) {
		$this->statuses = array( '' => __( 'Default', 'zephyr' ) );
		parent::__construct( $manager, $id, $args );
	}
		private function get_google_fonts() {
			if ( get_option('zephyr-gfont-local') == '' ) {
				$gfonts = wp_remote_get("https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyB_sYHXxXOfF5Kkq3Fb-7IxJ-nMtLCoaOM");
				update_option('zephyr-gfont-local', $gfonts['body']);
			}
			$gfonts_json = json_decode(get_option('zephyr-gfont-local'),true);
			foreach ( $gfonts_json['items'] as $font ) {
				$families[] = $font['family'];
			}
			return $families;
		}
		public function render_content() {
			?>
			<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			</label>
			<?php 
			$families = $this->get_google_fonts();
			?>
			<select <?php $this->link(); ?>>
				<?php foreach ( $families as $family ) { 
					$value = preg_replace('/\s+/', '+', $family); ?>
				<option value="<?php echo $value; ?>" <?php selected($this->value(), $value); ?>><?php echo $family; ?></option>
				<?php } ?>
			</select>
			<?php
		}
	}

	// Define all color controls
	
	$colors = array();
	$colors[] = array(
		'slug'=>'zephyr_line_color', 
		'default' => '#efefef',
		'label' => __('Separator lines', 'zephyr'),
		'transport' => 'postMessage',
		'section' => 'colors'
	);
	$colors[] = array(
		'slug'=>'zephyr_accent_color', 
		'default' => '#FFD773',
		'label' => __('Accent color', 'zephyr'),
		'transport' => 'postMessage',
		'section' => 'colors'
	);
	$colors[] = array(
		'slug'=>'zephyr_titles_color', 
		'default' => '#050505',
		'label' => __('Titles', 'zephyr'),
		'transport' => 'refresh',
		'section' => 'colors'
	);
	$colors[] = array(
		'slug'=>'zephyr_titles_hover_color', 
		'default' => '#020202',
		'label' => __('Titles hover', 'zephyr'),
		'transport' => 'refresh',
		'section' => 'colors'
	);
	$colors[] = array(
		'slug'=>'zephyr_link_color', 
		'default' => '#212121',
		'label' => __('Links color', 'zephyr'),
		'transport' => 'refresh',
		'section' => 'colors'
	);
	$colors[] = array(
		'slug'=>'zephyr_link_hover_color', 
		'default' => '#ababab',
		'label' => __('Links hover', 'zephyr'),
		'transport' => 'refresh',
		'section' => 'colors'
	);
	$colors[] = array(
		'slug'=>'zephyr_text_color', 
		'default' => '#878787',
		'label' => __('General text', 'zephyr'),
		'transport' => 'refresh',
		'section' => 'colors'
	);
	$colors[] = array(
		'slug'=>'zephyr_top_header_color',
		'default' => '#ffffff',
		'label' => __('First header row background', 'zephyr'),
		'transport' => 'postMessage',
		'section' => 'zephyr_header'
	);
	$colors[] = array(
		'slug'=>'zephyr_bottom_header_color',
		'default' => '#ffffff',
		'label' => __('Second header row background', 'zephyr'),
		'transport' => 'postMessage',
		'section' => 'zephyr_header'
	);
	$colors[] = array(
		'slug'=>'zephyr_bottom_header_color',
		'default' => '#ffffff',
		'label' => __('Second header row background', 'zephyr'),
		'transport' => 'postMessage',
		'section' => 'zephyr_header'
	);
	$colors[] = array(
		'slug'=>'zephyr_menu_color', 
		'default' => '#B0B0B0',
		'label' => __('Menu link color', 'zephyr'),
		'transport' => 'refresh',
		'section' => 'nav'
	);
	$colors[] = array(
		'slug'=>'zephyr_menu_hover_color',
		'default' => '#B0B0B0',
		'label' => __('Menu link hover color', 'zephyr'),
		'transport' => 'refresh',
		'section' => 'nav'
	);
	$colors[] = array(
		'slug'=>'zephyr_menu_selected_color',
		'default' => '#5c5c5c',
		'label' => __('Menu link selected color', 'zephyr'),
		'transport' => 'refresh',
		'section' => 'nav'
	);
	$colors[] = array(
		'slug'=>'zephyr_dropdown_text_color', 
		'default' => '#B0B0B0',
		'label' => __('Dropdown link color', 'zephyr'),
		'transport' => 'refresh',
		'section' => 'nav'
	);
	$colors[] = array(
		'slug'=>'zephyr_menu_border_color',
		'default' => '#e9e9e9',
		'label' => __('Dropdown border color', 'zephyr'),
		'transport' => 'refresh',
		'section' => 'nav'
	);
	$colors[] = array(
		'slug'=>'zephyr_search_line_color',
		'default' => '#9a9a9a',
		'label' => __('Search Line', 'zephyr'),
		'transport' => 'refresh',
		'section' => 'colors'
	);
	$i = 12;

	// Create settings and controls for each color defined above

	foreach( $colors as $color ) {
		$i++;
		$wp_customize->add_setting(
			$color['slug'], array(
				'default' => $color['default'],
				'type' => 'option', 
				'capability' => 'edit_theme_options',
				'transport' => $color['transport']
			)
		);
		$section = $color['section'];
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$color['slug'], 
				array('label' => $color['label'], 
				'section' => $section,
				'settings' => $color['slug'],
				'priority' => $i
				)
			)
		);
	}
	
	// Define settings for other options

	$wp_customize->add_setting('zephyr_logo', array(
		'default' => get_template_directory_uri().'/img/zephyr.png'
	));
	$wp_customize->add_setting('zephyr_logo_retina', array(
		'default' => get_template_directory_uri().'/img/zephyr.png'
	));
	$wp_customize->add_setting('zephyr_favicon', array() );
	$wp_customize->add_setting('zephyr_textlogo', array() );
	$wp_customize->add_setting('zephyr_textlogo_font', array() ) ;
	$wp_customize->add_setting('zephyr_textlogo_fontsize', array(
		'default' => '16'
	));
	$wp_customize->add_section('zephyr_settings' , array(
		'title' => __('General Settings','zephyr'),
	));
	$wp_customize->add_setting('zephyr_color_scheme', array());
	$wp_customize->add_setting('zephyr_layout', array(
		'default' => 'regular'
	));
	$wp_customize->add_setting('zephyr_sidebar_position', array(
		'default' => 'sidebar-left'
	));
	$wp_customize->add_setting('zephyr_sidebar_content', array(
		'default' => 'sidebar-recent'
	));
	$wp_customize->add_setting('zephyr_header_layout', array(
		'default' => 'inline'
	));
	$wp_customize->add_setting('zephyr_show_desc', array(
		'default' => false
	));
// feature to be added -> author layout
// 	$wp_customize->add_setting('zephyr_author_layout', array(
// 		'default' => 'regular'
// 	));
	$wp_customize->add_setting('zephyr_fontone', array(
		'default' => 'Gentium+Book+Basic'
	));
	$wp_customize->add_setting('zephyr_fonttwo', array(
		'default' => 'Titillium+Web'
	));
	$wp_customize->add_setting('zephyr_font_titles', array(
		'default' => 'Gentium+Book+Basic'
	));
	$wp_customize->add_setting('zephyr_font_titles_size', array(
		'default' => '32'
	));
	$wp_customize->add_setting('zephyr_font_titles_weight', array(
		'default' => '400'
	));
	$wp_customize->add_setting('zephyr_fonttwo_weight', array(
		'default' => '700'
	));
	$wp_customize->add_setting('zephyr_fonttwo_size', array(
		'default' => '11'
	));
	$wp_customize->add_setting('zephyr_sidemenu', array(
		'default' => 'sidemenu'
	));
	$wp_customize->add_setting('zephyr_footertext', array(
		'default' => '&copy; ' . date("Y") .' '. get_bloginfo('name')
	));
	$wp_customize->add_setting('zephyr_back_over', array(
		'default' => '0',
		'transport' => 'postMessage'
	));
	$wp_customize->add_setting('zephyr_background_video', array(
		'default' => ''
	));
	$wp_customize->add_setting('zephyr_background_youtube', array(
		'default' => ''
	));
	$wp_customize->add_setting('zephyr_infinite', array(
		'default' => '0'
	));
	$wp_customize->add_setting('zephyr_sidebar_sticky', array(
		'default' => '0'
	));
	$wp_customize->add_setting('zephyr_scrolltop', array(
		'default' => '1'
	));
	$wp_customize->add_setting('zephyr_header_bg');
	$wp_customize->add_setting('zephyr_header_align');
	$wp_customize->add_setting('zephyr_lines_top', array(
		'default' => false
	));
	$wp_customize->add_setting('zephyr_lines_bottom', array(
		'default' => false
	));
	$wp_customize->add_setting('zephyr_sticky_postside', array(
		'default' => true
	));

	// Define sections
	
	$wp_customize->add_section('layout' , array(
		'title' => __('Layout','zephyr'),
		'priority' => 20
	));
// 	$wp_customize->add_section('zephyr_author' , array(
// 		'title' => __('Author Layout','zephyr'),
// 		'priority' => 999,
// 		'description' => __('Navigate to an Author page to see the changes', 'zephyr')
// 	));
	$wp_customize->add_section('zephyr_fonts' , array(
		'title' => __('Fonts','zephyr'),
		'priority' => 999,
		'description' => __('Choose template fonts ( see', 'zephyr').' <a target="_blank" href="http://www.google.com/fonts">Google Fonts</a> )'
	));
	$wp_customize->add_section('zephyr_header' , array(
		'title' => __('Header','zephyr'),
		'priority' => 30,
		'description' => __('Choose header layout & settings', 'zephyr')
	));
	
	// Define Controls

	$wp_customize->add_control(
	   new WP_Customize_Image_Control( $wp_customize, 'logo', array(
			   'label'          => __( 'Site logo', 'zephyr' ),
			   'section'        => 'zephyr_settings',
			   'settings'       => 'zephyr_logo',
			   'priority' => '1'
	) ) );
	$wp_customize->add_control(
	   new WP_Customize_Image_Control( $wp_customize, 'logo_retina', array(
			   'label'          => __( 'Site logo Retina ( @2X )', 'zephyr' ),
			   'section'        => 'zephyr_settings',
			   'settings'       => 'zephyr_logo_retina',
			   'priority' => '2'
	) ) );
	$wp_customize->add_control(
	   new Zephyr_Favicon_Control( $wp_customize, 'zephyr_favicon', array(
			   'label'          => __( 'Favicon ( must be .ico, size 16x16 )', 'zephyr' ),
			   'section'        => 'zephyr_settings',
			   'settings'       => 'zephyr_favicon',
			   'priority' => '3'
    ) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'zephyr_textlogo', array(
				'label'          => __( 'Text logo ( with custom font )', 'zephyr' ),
				'section'        => 'zephyr_settings',
				'settings'       => 'zephyr_textlogo',
				'type'           => 'text',
				'priority' => '4'
	) ) );
	$wp_customize->add_control( new Zephyr_GFont_Picker( $wp_customize, 'zephyr_textlogo_font', array(
		'label'   => __('Text logo font', 'zephyr'),
		'section' => 'zephyr_settings',
		'settings'   => 'zephyr_textlogo_font',
		'priority' => '5'
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'zephyr_textlogo_fontsize', array(
				'label'          => __( 'Text logo font size ( px )', 'zephyr' ),
				'section'        => 'zephyr_settings',
				'settings'       => 'zephyr_textlogo_fontsize',
				'type'           => 'text',
				'priority' => '6'
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'zephyr_footertext', array(
				'label'          => __( 'Footer text', 'zephyr' ),
				'section'        => 'zephyr_settings',
				'settings'       => 'zephyr_footertext',
				'type'           => 'text',
				'priority' => '8'
	) ) );
	$wp_customize->add_control('zephyr_color_scheme', array(
		'label'      => __('Color scheme', 'zephyr'),
		'section'    => 'colors',
		'settings'   => 'zephyr_color_scheme',
		'type'       => 'radio',
		'priority' => 1,
		'choices'    => array(
			'dark'   => 'Dark ( light background )',
			'light'  => 'Light ( dark background )'
		),
	));
	$wp_customize->add_control('zephyr_layout', array(
		'label'      => __('Main layout', 'zephyr'),
		'section'    => 'layout',
		'settings'   => 'zephyr_layout',
		'type'       => 'radio',
		'priority'	 => '1',
		'choices'    => array(
			'regular'   => __('Full width', 'zephyr'),
			'boxed'  => __('Boxed', 'zephyr')
		),
	));
	$wp_customize->add_control('zephyr_sidebar_position', array(
		'label'      => __('Sidebar position', 'zephyr'),
		'section'    => 'layout',
		'settings'   => 'zephyr_sidebar_position',
		'type'       => 'radio',
		'priority'	 => '2',
		'choices'    => array(
			'sidebar-left'   => __('Left', 'zephyr'),
			'sidebar-right'  => __('Right', 'zephyr'),
			'no-sidebar'  => __('None', 'zephyr'),
		),
	));
	$wp_customize->add_control('zephyr_sidebar_content', array(
		'label'      => __('Sidebar content', 'zephyr'),
		'section'    => 'layout',
		'settings'   => 'zephyr_sidebar_content',
		'type'       => 'radio',
		'priority'	 => '30',
		'choices'    => array(
			'sidebar-recent'   => __('Recent posts', 'zephyr'),
			'sidebar-widgets'  => __('Widgets', 'zephyr'),
		),
	));
	$wp_customize->add_control('zephyr_sidemenu', array(
		'label'      => __('Mobile menu format', 'zephyr'),
		'section'    => 'layout',
		'settings'   => 'zephyr_sidemenu',
		'type'       => 'radio',
		'priority'	 => '40',
		'choices'    => array(
			'sidemenu'   => __('Slide side menu', 'zephyr'),
			'regular'  => __('Regular responsive menu', 'zephyr')
		),
	));
	$wp_customize->add_control('zephyr_infinite', array(
		'label'      => __('Infinite scrolling', 'zephyr'),
		'section'    => 'layout',
		'settings'   => 'zephyr_infinite',
		'type'       => 'radio',
		'priority'	 => '50',
		'choices'    => array(
			'0'   => __('Use regular pagination', 'zephyr'),
			'1'  => __('Use infinite scrolling', 'zephyr')
		),
	));
	$wp_customize->add_control('zephyr_sidebar_sticky', array(
		'label'      => __('Sticky Sidebar', 'zephyr'),
		'section'    => 'layout',
		'settings'   => 'zephyr_sidebar_sticky',
		'type'       => 'radio',
		'priority'	 => '32',
		'choices'    => array(
			'0'   => __('Yes', 'zephyr'),
			'1'  => __('No', 'zephyr')
		),
	));
	$wp_customize->add_control('zephyr_sticky_postside', array(
		'label'      => __('Sticky Post icons', 'zephyr'),
		'section'    => 'layout',
		'settings'   => 'zephyr_sticky_postside',
		'type'       => 'radio',
		'priority'	 => '34',
		'choices'    => array(
			true   => __('Yes', 'zephyr'),
			false  => __('No', 'zephyr')
		),
	));

	$wp_customize->add_control('zephyr_scrolltop', array(
		'label'      => __('Show scroll to top button', 'zephyr'),
		'section'    => 'layout',
		'settings'   => 'zephyr_scrolltop',
		'type'       => 'checkbox',
		'priority'	 => '60',
	));
	$wp_customize->add_control('zephyr_show_desc', array(
		'label'      => __('Show tagline under logo', 'zephyr'),
		'section'    => 'zephyr_header',
		'settings'   => 'zephyr_show_desc',
		'type'       => 'checkbox',
		'priority'	 => '4',
	));
	$wp_customize->add_control('zephyr_header_layout', array(
		'label'      => __('Header layout', 'zephyr'),
		'section'    => 'zephyr_header',
		'settings'   => 'zephyr_header_layout',
		'type'       => 'radio',
		'priority'	 => '1',
		'choices'    => array(
			'inline'   => __('One row', 'zephyr'),
			'tworows'  => __('Two rows', 'zephyr')
		),
	));
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'zephyr_header_bg', array(
	   'label'          => __( 'Upload a header Background', 'zephyr' ),
	   'section'        => 'zephyr_header',
	   'settings'       => 'zephyr_header_bg',
	   'priority'	 => '30',
	)));
	$wp_customize->add_control('zephyr_header_align', array(
		'label'      => __('Logo & tagline align', 'zephyr'),
		'section'    => 'zephyr_header',
		'settings'   => 'zephyr_header_align',
		'type'       => 'radio',
		'desc'		=> 'aaa',
		'priority'	 => '5',
		'choices'    => array(
			'logocenter'   => __('Center', 'zephyr'),
			'logoleft'  => __('Left', 'zephyr')
		),
	));
	$wp_customize->add_control('zephyr_lines_top', array(
		'label'      => __('Show lines around first row', 'zephyr'),
		'section'    => 'zephyr_header',
		'settings'   => 'zephyr_lines_top',
		'type'       => 'checkbox',
		'priority'	 => '26',
	));
	$wp_customize->add_control('zephyr_lines_bottom', array(
		'label'      => __('Show lines around second row', 'zephyr'),
		'section'    => 'zephyr_header',
		'settings'   => 'zephyr_lines_bottom',
		'type'       => 'checkbox',
		'priority'	 => '27',
	));

// feature to be added -> author layout
// 	$wp_customize->add_control('zephyr_author_layout', array(
// 		'label'      => __('Author Layout', 'zephyr'),
// 		'section'    => 'zephyr_author',
// 		'settings'   => 'zephyr_author_layout',
// 		'type'       => 'radio',
// 		'choices'    => array(
// 			'regular'   => 'Default',
// 			'withsidebar'  => 'With sidebar',
// 			'no-sidebar'  => 'Without sidebar',
// 		),
// 	));
	$wp_customize->add_control( new Zephyr_GFont_Picker( $wp_customize, 'zephyr_font_titles', array(
		'label'   => __('Titles', 'zephyr'),
		'section' => 'zephyr_fonts',
		'settings'   => 'zephyr_font_titles',
		'priority' => 10
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'zephyr_font_titles_size', array(
		'label'   => __('', 'zephyr'),
		'section' => 'zephyr_fonts',
		'settings'   => 'zephyr_font_titles_size',
		'type'       => 'text',
		'priority' 	 => 14
	) ) );
	$wp_customize->add_control('zephyr_font_titles_weight', array(
		'label'      => __('', 'zephyr'),
		'section'    => 'zephyr_fonts',
		'settings'   => 'zephyr_font_titles_weight',
		'type'       => 'select',
		'priority' => 12,
		'choices'    => array(
			'400'   => __('Normal', 'zephyr'),
			'700'   => __('Bold', 'zephyr'),
		),
	));
	$wp_customize->add_control( new Zephyr_GFont_Picker( $wp_customize, 'zephyr_fonttwo', array(
		'label'   => __('Functionality &amp;  Small Titles', 'zephyr'),
		'section' => 'zephyr_fonts',
		'settings'   => 'zephyr_fonttwo',
		'priority' => 20
	) ) );
	$wp_customize->add_control('zephyr_fonttwo_weight', array(
		'label'      => __('', 'zephyr'),
		'section'    => 'zephyr_fonts',
		'settings'   => 'zephyr_fonttwo_weight',
		'type'       => 'select',
		'priority' => 22,
		'choices'    => array(
			'400'   => __('Normal', 'zephyr'),
			'700'   => __('Bold', 'zephyr'),
		),
	));
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'zephyr_fonttwo_size', array(
		'label'   => __('', 'zephyr'),
		'section' => 'zephyr_fonts',
		'settings'   => 'zephyr_fonttwo_size',
		'type'       => 'text',
		'priority' 	 => 24
	) ) );
	$wp_customize->add_control( new Zephyr_GFont_Picker( $wp_customize, 'zephyr_fontone', array(
		'label'   => __('Informational &amp; Body', 'zephyr'),
		'section' => 'zephyr_fonts',
		'settings'   => 'zephyr_fontone',
		'priority' => 30
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'zephyr_back_over', array(
		'label'   => __('Background overlay opacity (%)', 'zephyr'),
		'section' => 'background_image',
		'settings'   => 'zephyr_back_over',
		'type'       => 'text',
		'priority' 	 => '100'
	) ) );
	$wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, 'zephyr_background_video', array(
			'label'      => __( 'Video Background', 'mytheme' ),
			'section'    => 'background_image',
			'settings'   => 'zephyr_background_video',
			'priority' 	 => '90'
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'zephyr_background_youtube', array(
			'label'          =>__( 'Youtube Video Background', 'mytheme' ),
			'section'        => 'background_image',
			'settings'       => 'zephyr_background_youtube',
			'type'           => 'text',
			'priority' => '93'
	) ) );
}
add_action( 'customize_register', 'zephyr_customize_register' );

// Add custom background functionality
$args = array(
	'default-color' => 'FFFFFF',
);
add_theme_support( 'custom-background', $args );

// Make some color changes live where
function zephyr_live_preview() {
      wp_enqueue_script( 
           'zephyr-themecustomizer',
           get_template_directory_uri() . '/js/zephyr-customizer.js',
           array(  'jquery', 'customize-preview' ),
           '',
           true
      );
}
add_action( 'customize_preview_init' , 'zephyr_live_preview' );

?>