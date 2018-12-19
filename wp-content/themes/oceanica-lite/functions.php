<?php
/**
 * Oceanica functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package oceanica-lite
 */
if ( ! function_exists( 'oceanica_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function oceanica_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on oceanica, use a find and replace
		 * to change 'oceanica-lite' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'oceanica-lite', get_template_directory() . '/languages' );

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
		set_post_thumbnail_size( 0, 560 );

		add_image_size( 'oceanica-thumb-large', 2000 );
		add_image_size( 'oceanica-thumb-medium', 840, 560, true );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'oceanica-lite' ),
			'menu-2' => esc_html__( 'Header Left', 'oceanica-lite' ),
			'menu-3' => esc_html__( 'Header Right', 'oceanica-lite' ),
			'menu-4' => esc_html__( 'Footer', 'oceanica-lite' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add page support excerpt.
		add_post_type_support( 'page', 'excerpt' );

		/*
		* This theme styles the visual editor to resemble the theme style,
		* specifically font, colors, icons, and column width.
		*/
		add_editor_style( array( 'css/editor-style.css', oceanica_fonts_url() ) );
	}
endif;
add_action( 'after_setup_theme', 'oceanica_setup' );

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
if ( ! isset( $content_width ) ) {
	$content_width = apply_filters( 'oceanica_content_width', 768 );
}


/**
 * Get theme vertion.
 *
 * @access public
 * @return string
 */
function oceanica_get_theme_version() {
	$theme_info = wp_get_theme( get_template() );

	return $theme_info->get( 'Version' );
}

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function oceanica_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'oceanica-lite' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'oceanica-lite' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Left', 'oceanica-lite' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Appears in the footer section of the site.', 'oceanica-lite' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Center', 'oceanica-lite' ),
		'id'            => 'sidebar-3',
		'description'   => esc_html__( 'Appears in the footer section of the site.', 'oceanica-lite' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Right', 'oceanica-lite' ),
		'id'            => 'sidebar-4',
		'description'   => esc_html__( 'Appears in the footer section of the site.', 'oceanica-lite' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Front Page Top', 'oceanica-lite' ),
		'id'            => 'sidebar-5',
		'description'   => esc_html__( 'Appears on the Front Page.', 'oceanica-lite' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Front Page Bottom', 'oceanica-lite' ),
		'id'            => 'sidebar-6',
		'description'   => esc_html__( 'Appears in the Home page.', 'oceanica-lite' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
    register_sidebar( array(
        'name'          => esc_html__( 'Shop', 'oceanica-lite' ),
        'id'            => 'shop',
        'description'   => esc_html__( 'Add widgets here.', 'oceanica-lite' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
     ) );
}

add_action( 'widgets_init', 'oceanica_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function oceanica_scripts() {

	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'oceanica-fonts', oceanica_fonts_url(), array(), null );
	wp_enqueue_style( 'oceanica-style', get_stylesheet_uri(), array(), oceanica_get_theme_version() );
	wp_enqueue_script( 'oceanica-navigation', get_template_directory_uri() . '/js/navigation.js', array(), oceanica_get_theme_version(), true );
	if ( is_plugin_active( 'jetpack/jetpack.php' ) ) {
		wp_enqueue_script( 'oceanica-flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array( 'jquery' ), oceanica_get_theme_version(), true );
	}
	wp_enqueue_script( 'oceanica-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), oceanica_get_theme_version(), true );
	wp_enqueue_script( 'oceanica-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), oceanica_get_theme_version(), true );

	wp_localize_script( 'oceanica-script', 'screenReaderText', array(
		'expand'   => esc_html__( 'expand child menu', 'oceanica-lite' ),
		'collapse' => esc_html__( 'collapse child menu', 'oceanica-lite' ),
	) );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'oceanica_scripts' );

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
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
* Load WooCommerce compatibility file.
*/
if(class_exists( 'WooCommerce' )){
 require get_template_directory() . '/inc/woocommerce.php';
}
if ( ! function_exists( 'oceanica_the_custom_logo' ) ) :
	/**
	 * Displays the optional custom logo.
	 *
	 * Does nothing if the custom logo is not available.
	 *
	 * @since Oceanica 1.0.0
	 */
	function oceanica_the_custom_logo() {
		if ( function_exists( 'the_custom_logo' ) ) {
			the_custom_logo();
		}
	}
endif;


if ( ! function_exists( 'oceanica_fonts_url' ) ) :
	/**
	 * Register Google fonts for Oceanica.
	 *
	 * Create your own oceanica_fonts_url() function to override in a child theme.
	 *
	 * @since Oceanica 1.0.0
	 *
	 * @return string Google fonts URL for the theme.
	 */
	function oceanica_fonts_url() {
		$fonts_url     = '';
		$font_families = array();

		/**
		 * Translators: If there are characters in your language that are not
		 * supported by Playfair Display, translate this to 'off'. Do not translate
		 * into your own language.
		 */
		$playfair_display = esc_html_x( 'on', 'Playfair Display font: on or off', 'oceanica-lite' );
		if ( 'off' !== $playfair_display ) {
			$font_families[] = 'Playfair Display:400,400i,700,700i,900,900i';
		}
		/**
		 * Translators: If there are characters in your language that are not
		 * supported by Poppins, translate this to 'off'. Do not translate
		 * into your own language.
		 */
		$poppins = esc_html_x( 'on', 'Poppins font: on or off', 'oceanica-lite' );
		if ( 'off' !== $poppins ) {
			$font_families[] = 'Poppins:300,400,500,600,700';
		}

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext,cyrillic' ),
		);
		if ( $font_families ) {
			$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
		}

		return esc_url_raw( $fonts_url );
	}
endif;
/**
 * Modifies tag cloud widget arguments to have all tags in the widget same font size.
 *
 * @since Oceanica 1.0.0
 *
 * @param array $args Arguments for tag cloud widget.
 *
 * @return array A new modified arguments.
 */
function oceanica_widget_tag_cloud_args( $args ) {
	$args['largest']  = 0.75;
	$args['smallest'] = 0.75;
	$args['unit']     = 'rem';

	return $args;
}

add_filter( 'widget_tag_cloud_args', 'oceanica_widget_tag_cloud_args' );

/*
 * Filters the title of the default page template displayed in the drop-down.
 */
function oceanica_default_page_template_title() {
	return esc_html__( 'Page with sidebar', 'oceanica-lite' );
}

add_filter( 'default_page_template_title', 'oceanica_default_page_template_title' );
