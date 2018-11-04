<?php
/**
 * gatsby functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package gatsby
 */

if ( ! function_exists( 'gatsby_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function gatsby_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on gatsby, use a find and replace
	 * to change 'gatsby' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'gatsby', get_template_directory() . '/languages' );

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
	 * Enable support for custom logo.
	 *
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 49,
		'width'       => 162,
		'flex-height' => true,
        'flex-width'  => true,
		'header-text' => array( 'site-title', 'site-description' ),
	) );


	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'gatsby-thumb-default', 260, 190, true );
	add_image_size( 'gatsby-thumb-layout2', 642, 300, true );
	add_image_size( 'gatsby-thumb-layout3', 305, 175, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'gatsby' ),
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

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'gatsby_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	/*
	 * Add support for Gutenberg.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/reference/theme-support/
	 */
	add_theme_support( 'align-wide' );


}
endif;
add_action( 'after_setup_theme', 'gatsby_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function gatsby_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'gatsby_content_width', 640 );
}
add_action( 'after_setup_theme', 'gatsby_content_width', 0 );


if ( ! function_exists( 'gatsby_fonts_url' ) ) :
/**
 * @return string Google fonts URL for the theme.
 */
function gatsby_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Noto Sans, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Source Sans Pro font: on or off', 'gatsby' ) ) {
		$fonts[] = 'Source Sans Pro:400italic,600italic,700italic,400,600,700';
	}

	/*
	 * Translators: To add an additional character subset specific to your language,
	 * translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language.
	 */
	$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'gatsby' );

	if ( 'cyrillic' == $subset ) {
		$subsets .= ',cyrillic,cyrillic-ext';
	} elseif ( 'greek' == $subset ) {
		$subsets .= ',greek,greek-ext';
	} elseif ( 'devanagari' == $subset ) {
		$subsets .= ',devanagari';
	} elseif ( 'vietnamese' == $subset ) {
		$subsets .= ',vietnamese';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function gatsby_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'gatsby' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'gatsby' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'gatsby' ),
		'id'            => 'footer',
		'description'   => esc_html__( 'Add widgets here.', 'gatsby' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'gatsby_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function gatsby_scripts() {

	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'gatsby-fonts', gatsby_fonts_url(), array(), null );

	// Add Font Awesome, used in the main stylesheet.
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array(), '4.5' );

	wp_enqueue_style( 'gatsby-style', get_stylesheet_uri() );
	// Add extra styling to patus-style
	$primary   = esc_attr( get_theme_mod( 'primary_color', '#e40018' ) );
	$secondary = esc_attr( get_theme_mod( 'secondary_color', '#494949' ) );
	$custom_css = "
			a{color: #{$secondary}; }
			.entry-meta a,
			.main-navigation a:hover,
			.main-navigation .current_page_item > a,
			.main-navigation .current-menu-item > a,
			.main-navigation .current_page_ancestor > a,
			.widget_tag_cloud a:hover,
			.social-links ul a:hover::before,
			a:hover,
			a.read-more
			 {
				 color : {$primary};
			 }
			button, input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"]{
				background: {$primary};
				border-color : {$primary};
			}
			.widget_tag_cloud a:hover { border-color : {$primary};}
			.main-navigation a,
			h2.entry-title a,
			h1.entry-title,
			.widget-title,
			.footer-staff-picks h3
			{
				color: {$secondary};
			}
			button:hover, input[type=\"button\"]:hover,
			input[type=\"reset\"]:hover,
			input[type=\"submit\"]:hover {
					background: {$secondary};
					border-color: {$secondary};
			}";
			wp_add_inline_style( 'gatsby-style', $custom_css );

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'gatsby-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script( 'gatsby-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'gatsby_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Widget posts
 */
require get_template_directory() . '/inc/posts-widget.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
