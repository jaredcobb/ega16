<?php
/**
 * EGA 16 functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ega16
 */

if ( ! function_exists( 'ega16_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function ega16_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on ega16, use a find and replace
		 * to change 'ega16' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'ega16', get_template_directory() . '/languages' );

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
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary', 'ega16' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
	}
endif;
add_action( 'after_setup_theme', 'ega16_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ega16_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'ega16_content_width', 640 );
}
add_action( 'after_setup_theme', 'ega16_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ega16_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'ega16' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'ega16' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'ega16_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ega16_scripts() {
	wp_enqueue_style( 'ega16-style', get_template_directory_uri() . '/static/css/style.css' );

	// Use google for possible caching / cdn benefits.
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', array(), '', true );

	wp_register_script( 'ega16-scripts', get_template_directory_uri() . '/static/js/ega16.dist.js', array( 'jquery' ), '', true );

	$data = array();

	$data['template_directory'] = get_template_directory_uri();
	$data['audio_enabled'] = EGA16_Audio::instance()->audio_enabled();
	$data['audio_page_hash'] = EGA16_Audio::instance()->get_audio_page_hash();
	$data['audio_toggle_file'] = EGA16_Audio::instance()->get_audio_toggle_file();
	$data['points_enabled'] = EGA16_Points::instance()->points_enabled();
	$data['points_page_selectors'] = EGA16_Points::instance()->get_points_page_selectors();
	$data['points_click_selectors'] = EGA16_Points::instance()->get_points_click_selectors();

	wp_localize_script( 'ega16-scripts', 'EGA16', $data );

	wp_enqueue_script( 'ega16-scripts' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ega16_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load custom navigation walker class
 */
require get_template_directory() . '/inc/class-ega16-foundation-topbar-walker.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/class-ega16-customizer.php';

/**
 * Audio helper class
 */
require get_template_directory() . '/inc/class-ega16-audio.php';

/**
 * Points helper class
 */
require get_template_directory() . '/inc/class-ega16-points.php';
