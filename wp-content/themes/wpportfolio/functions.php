<?php 

// ---**---**---**---**---**---**---**---**---**---**
// ----- Load the Theme CSS ----- 
// ---**---**---**---**---**---**---**---**---**---**



function theme_styles() {

	wp_enqueue_style( 'normalize' , get_template_directory_uri() . '/css/normalize.css' );
	wp_enqueue_style( 'grid' , get_template_directory_uri() . '/css/grid.css' );
	wp_enqueue_style( 'main' , get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'social' , get_template_directory_uri() . '/css/webfonts/ss-social.css' );
	wp_enqueue_style( 'googlefonts' , 'http://fonts.googleapis.com/css?family=Sorts+Mill+Goudy:400,400italic' );

	wp_register_style( 'flexslider' , get_template_directory_uri() . '/css/flexslider.css' );	
		if ( is_page ( 'home' ) ) {
			wp_enqueue_style( 'flexslider' );
		};
};

 
	

// ---**---**---**---**---**---**---**---**---**---**
// ----- Load the Theme JS ----- 
// ---**---**---**---**---**---**---**---**---**---**



function theme_js() {

	wp_register_script( 'flexslider', get_template_directory_uri() . '/js/flexslider.js', array('jquery'), '', true );
	if ( is_page ( 'home' ) ) {
			wp_enqueue_script( 'flexslider' );
		};
	
	wp_enqueue_script( 'theme_js', get_template_directory_uri() . '/js/theme.js', array('jquery'), '', true );
};
	
	add_action( 'wp_enqueue_scripts', 'theme_js' );
	add_action( 'wp_enqueue_scripts', 'theme_styles' );

 

// ---**---**---**---**---**---**---**---**---**---**
// ----- Enable Custom Menus ----- 
// ---**---**---**---**---**---**---**---**---**---**



add_theme_support( 'menus' );



// ---**---**---**---**---**---**---**---**---**---**
// ----- Add Widgets ----- 
// ---**---**---**---**---**---**---**---**---**---**
	
	function create_widget( $name, $id, $description ) {
		$args = array(
			'name'          => __( $name ),
			'id'            => $id,
			'description'   => $description,
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '<h5>',
			'after_title'   => '</h5>'
			);

		register_sidebar( $args );
	};

	create_widget( 'Left Footer', "footer_left", "Displays in the bottom left of footer" );
	create_widget( 'Middle Footer', "footer_middle", "Displays in the center of the footer" );
	create_widget( 'Right Footer', "footer_right", "Displays in the right of the footer" );
 ?>
