<?php
/**
 * lifepropulse functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package lifepropulse
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'lifepropulse_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function lifepropulse_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on lifepropulse, use a find and replace
		 * to change 'lifepropulse' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'lifepropulse', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Header', 'lifepropulse' ),
				'menu-2' => esc_html__( 'Footer', 'lifepropulse' ),
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
	}
endif;
add_action( 'after_setup_theme', 'lifepropulse_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function lifepropulse_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'lifepropulse_content_width', 640 );
}
add_action( 'after_setup_theme', 'lifepropulse_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function lifepropulse_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'lifepropulse' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'lifepropulse' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'lifepropulse_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function lifepropulse_scripts() {
	// CSS
	wp_enqueue_style( 'fontawesome-style', 'https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.2/css/all.css', array(), '5.15.2');
	wp_enqueue_style( 'lifepropulse-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_style( 'fontawesome', 'https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.2/css/all.css', array(), "3.5.1" );

	// JS
	wp_deregister_script('jquery');
    wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.5.1.min.js', array(), '3.5.1', true );
    wp_enqueue_script('jszip', 'https://kendo.cdn.telerik.com/2017.2.621/js/jszip.min.js', array(), _S_VERSION, true );
    wp_enqueue_script('kendo', 'https://kendo.cdn.telerik.com/2017.2.621/js/kendo.all.min.js', array(), _S_VERSION, true );
    wp_enqueue_script('js', get_template_directory_uri() . '/asset/js/main.js', array(), '1.0.0', true );
    wp_enqueue_script('navigation', get_template_directory_uri() . '/asset/js/navigation.js', array(), '1.0.0', true );
    wp_enqueue_script('pdf', get_template_directory_uri() . '/asset/js/pdf.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'lifepropulse_scripts' );

function my_phpmailer_example( $phpmailer ) {
    $phpmailer->isSMTP();     
    $phpmailer->Host = 'smtp.gmail.com';
    $phpmailer->SMTPAuth = true; // Ask it to use authenticate using the Username and Password properties
    $phpmailer->Port = '465';
    $phpmailer->Username = 'lifepropulse@gmail.com';
	// à mettre dans config
    $phpmailer->Password = 'Azerty@@11';
 
    // Additional settings…
    $phpmailer->SMTPSecure = 'ssl'; // Choose 'ssl' for SMTPS on port 465, or 'tls' for SMTP+STARTTLS on port 25 or 587
    //$phpmailer->From = "you@yourdomail.com";
    //$phpmailer->FromName = "Your Name";
}

add_action( 'phpmailer_init', 'my_phpmailer_example' );

// Cacher la bar de l'admin
add_filter( 'show_admin_bar', '__return_false' );