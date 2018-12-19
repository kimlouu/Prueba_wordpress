<?php
/**
 * Oceanica Theme Customizer
 *
 * @package oceanica-lite
 */


/**
 * Sets up the WordPress core custom header and custom background features.
 *
 * @since Oceanica 1.0
 *
 * @see oceanica_header_style()
 */
function oceanica_custom_header_and_background()
{
    $color_scheme = oceanica_get_color_scheme();
    $default_background_color = trim($color_scheme[0], '#');
    $default_text_color = trim($color_scheme[3], '#');

    /**
     * Filter the arguments used when adding 'custom-background' support in Oceanica.
     *
     * @since Oceanica 1.0
     *
     * @param array $args {
     *     An array of custom-background support arguments.
     *
     * @type string $default -color Default color of the background.
     * }
     */
    add_theme_support('custom-background', apply_filters('oceanica_custom_background_args', array(
        'default-color' => $default_background_color,
    )));

    /**
     * Filter the arguments used when adding 'custom-header' support in Oceanica.
     *
     * @since Oceanica 1.0
     *
     * @param array $args {
     *     An array of custom-header support arguments.
     *
     * @type string $default -text-color Default color of the header text.
     * @type int $width Width in pixels of the custom header image. Default 1200.
     * @type int $height Height in pixels of the custom header image. Default 280.
     * @type bool $flex -height      Whether to allow flexible-height header images. Default true.
     * @type callable $wp -head-callback Callback function used to style the header image and text
     *                                      displayed on the blog.
     * }
     */
    add_theme_support('custom-header', apply_filters('oceanica_custom_header_args', array(
        'default-text-color' => $default_text_color,
        'width' => 1000,
        'height' => 250,
        'flex-height' => true,
        'wp-head-callback' => 'oceanica_header_style',
    )));
    add_theme_support('custom-logo', array(
        'height' => 58,
        'width' => 58,
        'flex-height' => true,
        'flex-width' => true,
        'header-text' => array('site-title', 'site-description'),
    ));
}

add_action('after_setup_theme', 'oceanica_custom_header_and_background');

if (!function_exists('oceanica_header_style')) :
    /**
     * Styles the header text displayed on the site.
     *
     * Create your own oceanica_header_style() function to override in a child theme.
     *
     * @since Oceanica 1.0
     *
     * @see oceanica_custom_header_and_background().
     */
    function oceanica_header_style()
    {
        // If the header text option is untouched, let's bail.
        if (display_header_text()) {
            return;
        }

        // If the header text has been hidden.
        ?>
        <style type="text/css" id="oceanica-header-css">
            .site-branding {
                margin: 0 auto 0 0;
            }

            .site-branding .site-title,
            .site-description {
                clip: rect(1px, 1px, 1px, 1px);
                position: absolute;
            }
        </style>
        <?php
    }
endif; // oceanica_header_style

/**
 * Adds postMessage support for site title and description for the Customizer.
 *
 * @since Oceanica 1.0
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function oceanica_customize_register($wp_customize)
{
    $color_scheme = oceanica_get_color_scheme();

    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';

    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial('blogname', array(
            'selector' => '.site-title a',
            'container_inclusive' => false,
            'render_callback' => 'oceanica_customize_partial_blogname',
        ));
        $wp_customize->selective_refresh->add_partial('blogdescription', array(
            'selector' => '.site-description',
            'container_inclusive' => false,
            'render_callback' => 'oceanica_customize_partial_blogdescription',
        ));
    }


    // Remove the core header textcolor control, as it shares the main text color.
    $wp_customize->remove_control('header_textcolor');
    //Remove the core header image control.
    $wp_customize->remove_control('header_image');


// Add main text color setting and control.
    $wp_customize->add_setting('main_text_color', array(
        'default' => $color_scheme[1],
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'main_text_color', array(
        'label' => esc_html__('Main Text Color', 'oceanica-lite'),
        'section' => 'colors',
    )));

    // Add Brand color setting and control.
    $wp_customize->add_setting('brand_color', array(
        'default' => $color_scheme[2],
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'brand_color', array(
        'label' => esc_html__('Link Color', 'oceanica-lite'),
        'section' => 'colors',
    )));

    // Add Hover Brand color setting and control.
    $wp_customize->add_setting('brand_color_hover', array(
        'default' => $color_scheme[3],
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'brand_color_hover', array(
        'label' => esc_html__('Button Hover Color', 'oceanica-lite'),
        'section' => 'colors',
    )));

}

add_action('customize_register', 'oceanica_customize_register', 11);

/**
 * Render the site title for the selective refresh partial.
 *
 * @since Oceanica 1.2
 * @see oceanica_customize_register()
 *
 * @return void
 */
function oceanica_customize_partial_blogname()
{
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @since Oceanica 1.2
 * @see oceanica_customize_register()
 *
 * @return void
 */
function oceanica_customize_partial_blogdescription()
{
    bloginfo('description');
}

/**
 * Registers color schemes for Oceanica.
 *
 * Can be filtered with {@see 'oceanica_color_schemes'}.
 *
 * The order of colors in a colors array:
 * 1. Main Background Color.
 * 2. Page Background Color.
 * 3. Link Color.
 * 4. Main Text Color.
 * 5. Secondary Text Color.
 *
 * @since Oceanica 1.0
 *
 * @return array An associative array of color scheme options.
 */
function oceanica_get_color_schemes()
{
    /**
     * Filter the color schemes registered for use with Oceanica.
     *
     * The default schemes include 'default', 'dark', 'gray', 'red', and 'yellow'.
     *
     * @since Oceanica 1.0
     *
     * @param array $schemes {
     *     Associative array of color schemes data.
     *
     * @type array $slug {
     *         Associative array of information for setting up the color scheme.
     *
     * @type string $label Color scheme label.
     * @type array $colors HEX codes for default colors prepended with a hash symbol ('#').
     *                              Colors are defined in the following order: Main background, page
     *                              background, link, main text, secondary text.
     *     }
     * }
     */
    return apply_filters('oceanica_color_schemes', array(
        'default' => array(
            'label' => esc_html__('Default', 'oceanica-lite'),
            'colors' => array(
                '#ffffff',
                '#484848',
                '#0489ef',
                '#48b0ff',
            ),
        )
    ));
}

if (!function_exists('oceanica_get_color_scheme')) :
    /**
     * Retrieves the current Oceanica color scheme.
     *
     * Create your own oceanica_get_color_scheme() function to override in a child theme.
     *
     * @since Oceanica 1.0
     *
     * @return array An associative array of either the current or default color scheme HEX values.
     */
    function oceanica_get_color_scheme()
    {
        $color_scheme_option = get_theme_mod('color_scheme', 'default');
        $color_schemes = oceanica_get_color_schemes();

        if (array_key_exists($color_scheme_option, $color_schemes)) {
            return $color_schemes[$color_scheme_option]['colors'];
        }

        return $color_schemes['default']['colors'];
    }
endif; // oceanica_get_color_scheme

if (!function_exists('oceanica_get_color_scheme_choices')) :
    /**
     * Retrieves an array of color scheme choices registered for Oceanica.
     *
     * Create your own oceanica_get_color_scheme_choices() function to override
     * in a child theme.
     *
     * @since Oceanica 1.0
     *
     * @return array Array of color schemes.
     */
    function oceanica_get_color_scheme_choices()
    {
        $color_schemes = oceanica_get_color_schemes();
        $color_scheme_control_options = array();

        foreach ($color_schemes as $color_scheme => $value) {
            $color_scheme_control_options[$color_scheme] = $value['label'];
        }

        return $color_scheme_control_options;
    }
endif; // oceanica_get_color_scheme_choices


if (!function_exists('oceanica_sanitize_color_scheme')) :
    /**
     * Handles sanitization for Oceanica color schemes.
     *
     * Create your own oceanica_sanitize_color_scheme() function to override
     * in a child theme.
     *
     * @since Oceanica 1.0
     *
     * @param string $value Color scheme name value.
     *
     * @return string Color scheme name.
     */
    function oceanica_sanitize_color_scheme($value)
    {
        $color_schemes = oceanica_get_color_scheme_choices();

        if (!array_key_exists($value, $color_schemes)) {
            return 'default';
        }

        return $value;
    }
endif; // oceanica_sanitize_color_scheme

/**
 * Enqueues front-end CSS for color scheme.
 *
 * @since Oceanica 1.0
 *
 * @see wp_add_inline_style()
 */
function oceanica_color_scheme_css()
{
    $color_scheme_option = get_theme_mod('color_scheme', 'default');

    // Don't do anything if the default color scheme is selected.
    if ('default' === $color_scheme_option) {
        return;
    }

    $color_scheme = oceanica_get_color_scheme();


    // If we get this far, we have a custom color scheme.
    $colors = array(
        'background_color' => $color_scheme[0],
        'main_text_color' => $color_scheme[1],
        'brand_color' => $color_scheme[2],
        'secondary_text_color' => $color_scheme[3],

    );

    $color_scheme_css = oceanica_get_color_scheme_css($colors);

    wp_add_inline_style('oceanica-style', $color_scheme_css);
}

add_action('wp_enqueue_scripts', 'oceanica_color_scheme_css');

/**
 * Returns CSS for the color schemes.
 *
 * @since Oceanica 1.0
 *
 * @param array $colors Color scheme colors.
 *
 * @return string Color scheme CSS.
 */
function oceanica_get_color_scheme_css($colors)
{
    $colors = wp_parse_args($colors, array(
        'background_color' => '',
        'main_text_color' => '',
        'brand_color' => '',
        'brand_color_hover' => '',
    ));


    return <<<CSS
	/* Color Scheme */

	/* Background Color */
	body {
		background-color: {$colors['background_color']};
	}

	
	/* Brand Color */
	a,.sticky-post-wrapper,
	.post-navigation a:hover,
	.footer-navigation a:hover, 
	.top-navigation a:hover, 
	.top-navigation-right a:hover, 
	.main-navigation a:hover,
	.footer-navigation .current_page_item > a, 
	.footer-navigation .current-menu-item > a, 
	.footer-navigation .current_page_ancestor > a, 
	.footer-navigation .current-menu-ancestor > a, 
	.top-navigation .current_page_item > a, 
	.top-navigation .current-menu-item > a, 
	.top-navigation .current_page_ancestor > a, 
	.top-navigation .current-menu-ancestor > a, 
	.top-navigation-right .current_page_item > a, 
	.top-navigation-right .current-menu-item > a, 
	.top-navigation-right .current_page_ancestor > a, 
	.top-navigation-right .current-menu-ancestor > a, 
	.main-navigation .current_page_item > a, 
	.main-navigation .current-menu-item > a, 
	.main-navigation .current_page_ancestor > a, 
	.main-navigation .current-menu-ancestor > a,
	body.search .site-main .entry-footer a:hover, 
	body.archive .site-main .entry-footer a:hover, 
	body.blog .site-main .entry-footer a:hover,
	.entry-title a:hover,
	.site-branding .site-title a:hover,
	.menu-toggle:hover,
	.widget.widget_wpcom_social_media_icons_widget a.genericon:hover{
		color: {$colors['brand_color']};
	}
	body .datepick-ctrl .datepick-cmd{
		color: {$colors['brand_color']}!important;
	}
	button,
	.button,
	input[type="button"], 
	input[type="reset"], 
	input[type="submit"],
	.tagcloud a:hover,
	.flex-control-paging li a.flex-active, .flex-control-paging li a:hover,
	.entry-child-pages-list .more-link{	
        border-color: {$colors['brand_color']};
		background-color: {$colors['brand_color']};
	}
	button:hover,
	.button:hover,
	button:focus,
	.button:focus,
	input[type="button"]:hover, 
	input[type="reset"]:hover, 
	input[type="submit"]:hover,
	input[type="button"]:focus, 
	input[type="reset"]:focus, 
	input[type="submit"]:focus,
	.entry-child-pages-list .more-link:hover,
	.entry-child-pages-list .more-link:focus{
        border-color: {$colors['brand_color_hover']};
		background-color: {$colors['brand_color_hover']};
	}
	.footer-navigation .theme-social-menu a[href*="twitter.com"]:hover,
	.footer-navigation .theme-social-menu a[href*="facebook.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="plus.google.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="pinterest.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="foursquare.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="yahoo.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="skype:"]:hover, 
	.footer-navigation .theme-social-menu a[href*="yelp.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="linkedin.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="viadeo.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="xing.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="soundcloud.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="spotify.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="last.fm"]:hover, 
	.footer-navigation .theme-social-menu a[href*="youtube.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="vimeo.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="vine.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="flickr.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="500px.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="instagram.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="tumblr.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="reddit.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="dribbble.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="stumbleupon.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="digg.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="behance.net"]:hover, 
	.footer-navigation .theme-social-menu a[href*="delicious.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="deviantart.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="play.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="wikipedia.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="apple.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="github.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="github.io"]:hover, 
	.footer-navigation .theme-social-menu a[href*="windows.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="tripadvisor."]:hover, 
	.footer-navigation .theme-social-menu a[href*="slideshare.net"]:hover, 
	.footer-navigation .theme-social-menu a[href*=".rss"]:hover, 
	.footer-navigation .theme-social-menu a[href*="vk.com"]:hover,
	.pagination .prev:hover,
	.pagination .next:hover,
	mark, 
	ins{
		background-color: {$colors['brand_color']};
	}
	

	/* Main Text Color */
	body,
		 select, 
		 input[type="text"], 
		 input[type="email"], 
		 input[type="url"], 
		 input[type="password"], 
		 input[type="search"], 
		 input[type="number"], 
		 input[type="tel"], 
		 input[type="range"], 
		 input[type="date"], 
		 input[type="month"], 
		 input[type="week"], 
		 input[type="time"], 
		 input[type="datetime"], 
		 input[type="datetime-local"], 
		 input[type="color"], 
		 textarea{
		color: {$colors['main_text_color']};
	}
		 body  .datepick{
		color: {$colors['main_text_color']}!important;
	}
	a:focus {
        outline-color: {$colors['main_text_color']};
    }	
    body .site-header-cart .cart-contents:hover,
    body.woocommerce p.stars.selected a.active::before, body.woocommerce p.stars.selected a:not(.active)::before, body.woocommerce p.stars:hover a::before, body.woocommerce p.stars a:hover::before,
    body .woocommerce p.stars.selected a.active::before, body .woocommerce p.stars.selected a:not(.active)::before, body .woocommerce p.stars:hover a::before, body .woocommerce p.stars a:hover::before,
    body.woocommerce div.product .woocommerce-tabs ul.tabs li a,
    body.woocommerce .woocommerce-breadcrumb a,
    body .woocommerce .woocommerce-breadcrumb a,
    body .woocommerce .star-rating span::before,
    body .woocommerce ul.products li.product .woocommerce-loop-product__link:hover,
    body.woocommerce .star-rating span::before,
    body.woocommerce ul.products li.product .woocommerce-loop-product__link:hover{
      color: {$colors['brand_color']};
    }
    body .woocommerce a.remove:hover,
    body.woocommerce a.remove:hover{
      color: {$colors['brand_color']};!important;
    }
    body .woocommerce #respond input#submit.alt, body .woocommerce a.button.alt, body .woocommerce button.button.alt, body .woocommerce input.button.alt,
    body.woocommerce #respond input#submit.alt, body.woocommerce a.button.alt, body.woocommerce button.button.alt, body.woocommerce input.button.alt,
    body.woocommerce .widget_price_filter .ui-slider .ui-slider-handle:hover,
    body .woocommerce .widget_price_filter .ui-slider .ui-slider-handle:hover,
    body .widget .woocommerce-product-search:before,
    body .woocommerce nav.woocommerce-pagination ul li a.prev:hover, body .woocommerce nav.woocommerce-pagination ul li a.next:hover
    body.woocommerce nav.woocommerce-pagination ul li a.prev:hover, body.woocommerce nav.woocommerce-pagination ul li a.next:hover,
    body .woocommerce #respond input#submit, body .woocommerce a.button, body .woocommerce button.button, body .woocommerce input.button,
    body.woocommerce #respond input#submit, body.woocommerce a.button, body.woocommerce button.button, body.woocommerce input.button{
       background-color: {$colors['brand_color']};;
    }
    body.woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
    body .woocommerce #respond input#submit, body .woocommerce a.button, body .woocommerce button.button, body .woocommerce input.button,
    body.woocommerce #respond input#submit, body.woocommerce a.button, body.woocommerce button.button, body.woocommerce input.button{
       border-color: {$colors['brand_color']};;
    }
    body .woocommerce #respond input#submit.alt:hover, body .woocommerce a.button.alt:hover, body .woocommerce button.button.alt:hover, body .woocommerce input.button.alt:hover,
    body.woocommerce #respond input#submit.alt:hover, body.woocommerce a.button.alt:hover, body.woocommerce button.button.alt:hover, body.woocommerce input.button.alt:hover,
    body.woocommerce #respond input#submit:hover, body.woocommerce a.button:hover, body.woocommerce button.button:hover, body.woocommerce input.button:hover,
    body .woocommerce #respond input#submit:hover, body .woocommerce a.button:hover, body .woocommerce button.button:hover, body .woocommerce input.button:hover{
       background-color: {$colors['brand_color_hover']};
    }
    body.woocommerce #respond input#submit:hover, body.woocommerce a.button:hover, body.woocommerce button.button:hover, body.woocommerce input.button:hover,
    body .woocommerce #respond input#submit:hover, body .woocommerce a.button:hover, body .woocommerce button.button:hover, body .woocommerce input.button:hover{
        border-color: {$colors['brand_color_hover']};
    }
    body .woocommerce div.product .woocommerce-grouped-product-list-item__price, body .woocommerce div.product .woocommerce-variation-price .price, body .woocommerce div.product p.price,
    body.woocommerce div.product .woocommerce-grouped-product-list-item__price, body.woocommerce div.product .woocommerce-variation-price .price, body.woocommerce div.product p.price,
    body.woocommerce ul.products li.product .price,
    body .woocommerce ul.products li.product .price{
        color:{$colors['main_text_color']};
    }
CSS;
}


/**
 * Outputs an Underscore template for generating CSS for the color scheme.
 *
 * The template generates the css dynamically for instant display in the
 * Customizer preview.
 *
 * @since Oceanica 1.0
 */
function oceanica_color_scheme_css_template()
{
    $colors = array(
        'background_color' => '{{ data.background_color }}',
        'main_text_color' => '{{ data.main_text_color }}',
        'brand_color' => '{{ data.brand_color }}',
        'brand_color_hover' => '{{ data.brand_color_hover }}',
    );
    ?>
    <script type="text/html" id="tmpl-oceanica-color-scheme">
        <?php echo oceanica_get_color_scheme_css($colors); ?>
    </script>
    <?php
}

add_action('customize_controls_print_footer_scripts', 'oceanica_color_scheme_css_template');


/**
 * Enqueues front-end CSS for the link color.
 *
 * @since Oceanica 1.0
 *
 * @see wp_add_inline_style()
 */
function oceanica_brand_color_css()
{
    $color_scheme = oceanica_get_color_scheme();
    $default_color = $color_scheme[2];
    $brand_color = get_theme_mod('brand_color', $default_color);

    // Don't do anything if the current color is the default.
    if ($brand_color === $default_color) {
        return;
    }

    $css = '	
	a,.sticky-post-wrapper,
	.post-navigation a:hover,
	.footer-navigation a:hover, 
	.top-navigation a:hover, 
	.top-navigation-right a:hover, 
	.main-navigation a:hover,
	.footer-navigation .current_page_item > a, 
	.footer-navigation .current-menu-item > a, 
	.footer-navigation .current_page_ancestor > a, 
	.footer-navigation .current-menu-ancestor > a, 
	.top-navigation .current_page_item > a, 
	.top-navigation .current-menu-item > a, 
	.top-navigation .current_page_ancestor > a, 
	.top-navigation .current-menu-ancestor > a, 
	.top-navigation-right .current_page_item > a, 
	.top-navigation-right .current-menu-item > a, 
	.top-navigation-right .current_page_ancestor > a, 
	.top-navigation-right .current-menu-ancestor > a, 
	.main-navigation .current_page_item > a, 
	.main-navigation .current-menu-item > a, 
	.main-navigation .current_page_ancestor > a, 
	.main-navigation .current-menu-ancestor > a,
	body.search .site-main .entry-footer a:hover, 
	body.archive .site-main .entry-footer a:hover, 
	body.blog .site-main .entry-footer a:hover,
	.entry-title a:hover,
	.site-branding .site-title a:hover,
	.menu-toggle:hover,
	.widget.widget_wpcom_social_media_icons_widget a.genericon:hover{
		color: %1$s;
	}
	body .datepick-ctrl .datepick-cmd{
		color: %1$s!important;
	}
	button,
	.button,
	input[type="button"], 
	input[type="reset"], 
	input[type="submit"],
	.tagcloud a:hover,
	.flex-control-paging li a.flex-active, .flex-control-paging li a:hover,
	.entry-child-pages-list .more-link{	
        border-color: %1$s;
		background-color: %1$s;
	}
	.footer-navigation .theme-social-menu a[href*="twitter.com"]:hover,
	.footer-navigation .theme-social-menu a[href*="facebook.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="plus.google.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="pinterest.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="foursquare.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="yahoo.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="skype:"]:hover, 
	.footer-navigation .theme-social-menu a[href*="yelp.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="linkedin.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="viadeo.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="xing.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="soundcloud.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="spotify.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="last.fm"]:hover, 
	.footer-navigation .theme-social-menu a[href*="youtube.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="vimeo.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="vine.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="flickr.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="500px.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="instagram.com"]:hover,  
	.footer-navigation .theme-social-menu a[href*="tumblr.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="reddit.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="dribbble.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="stumbleupon.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="digg.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="behance.net"]:hover, 
	.footer-navigation .theme-social-menu a[href*="delicious.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="deviantart.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="play.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="wikipedia.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="apple.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="github.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="github.io"]:hover, 
	.footer-navigation .theme-social-menu a[href*="windows.com"]:hover, 
	.footer-navigation .theme-social-menu a[href*="tripadvisor."]:hover, 
	.footer-navigation .theme-social-menu a[href*="slideshare.net"]:hover, 
	.footer-navigation .theme-social-menu a[href*=".rss"]:hover, 
	.footer-navigation .theme-social-menu a[href*="vk.com"]:hover,
	.pagination .prev:hover,
	.pagination .next:hover,
	mark, 
	ins{
		background-color: %1$s;
	}';
    if (class_exists('WooCommerce')) {
        $css .= '
            body .site-header-cart .cart-contents:hover,
            body.woocommerce p.stars.selected a.active::before, body.woocommerce p.stars.selected a:not(.active)::before, body.woocommerce p.stars:hover a::before, body.woocommerce p.stars a:hover::before,
            body .woocommerce p.stars.selected a.active::before, body .woocommerce p.stars.selected a:not(.active)::before, body .woocommerce p.stars:hover a::before, body .woocommerce p.stars a:hover::before,
            body.woocommerce div.product .woocommerce-tabs ul.tabs li a,
            body.woocommerce .woocommerce-breadcrumb a,
            body .woocommerce .woocommerce-breadcrumb a,
            body .woocommerce .star-rating span::before,
            body .woocommerce ul.products li.product .woocommerce-loop-product__link:hover,
            body.woocommerce .star-rating span::before,
            body.woocommerce ul.products li.product .woocommerce-loop-product__link:hover{
                color: %1$s;
            }
            body .woocommerce a.remove:hover,
            body.woocommerce a.remove:hover{
                color: %1$s!important;
            }
            body .woocommerce #respond input#submit.alt, body .woocommerce a.button.alt, body .woocommerce button.button.alt, body .woocommerce input.button.alt,
            body.woocommerce #respond input#submit.alt, body.woocommerce a.button.alt, body.woocommerce button.button.alt, body.woocommerce input.button.alt,
            body.woocommerce .widget_price_filter .ui-slider .ui-slider-handle:hover,
            body .woocommerce .widget_price_filter .ui-slider .ui-slider-handle:hover,
            body .widget .woocommerce-product-search:before,
            body .woocommerce nav.woocommerce-pagination ul li a.prev:hover, body .woocommerce nav.woocommerce-pagination ul li a.next:hover
            body.woocommerce nav.woocommerce-pagination ul li a.prev:hover, body.woocommerce nav.woocommerce-pagination ul li a.next:hover,
            body .woocommerce #respond input#submit, body .woocommerce a.button, body .woocommerce button.button, body .woocommerce input.button,
            body.woocommerce #respond input#submit, body.woocommerce a.button, body.woocommerce button.button, body.woocommerce input.button{
                background-color: %1$s;
            }
            body.woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
            body .woocommerce #respond input#submit, body .woocommerce a.button, body .woocommerce button.button, body .woocommerce input.button,
            body.woocommerce #respond input#submit, body.woocommerce a.button, body.woocommerce button.button, body.woocommerce input.button{
                border-color: %1$s;
            }
        ';
    }
    wp_add_inline_style('oceanica-style', sprintf($css, $brand_color));
}

add_action('wp_enqueue_scripts', 'oceanica_brand_color_css', 11);

/**
 * Enqueues front-end CSS for the main text color.
 *
 * @since Oceanica 1.0
 *
 * @see wp_add_inline_style()
 */
function oceanica_main_text_color_css()
{
    $color_scheme = oceanica_get_color_scheme();
    $default_color = $color_scheme[1];
    $main_text_color = get_theme_mod('main_text_color', $default_color);

    // Don't do anything if the current color is the default.
    if ($main_text_color === $default_color) {
        return;
    }

    $css = '
		/* Custom Main Text Color */
		body,
		 select, 
		 input[type="text"], 
		 input[type="email"], 
		 input[type="url"], 
		 input[type="password"], 
		 input[type="search"], 
		 input[type="number"], 
		 input[type="tel"], 
		 input[type="range"], 
		 input[type="date"], 
		 input[type="month"], 
		 input[type="week"], 
		 input[type="time"], 
		 input[type="datetime"], 
		 input[type="datetime-local"], 
		 input[type="color"], 
		 textarea{
			color: %1$s;
		}		
		 body  .datepick{
			color: %1$s!important;
		}	
		a:focus {
          outline-color: %1$s;
        }	
	';
    if (class_exists('WooCommerce')) {
        $css .= '
            body .woocommerce div.product .woocommerce-grouped-product-list-item__price, body .woocommerce div.product .woocommerce-variation-price .price, body .woocommerce div.product p.price,
            body.woocommerce div.product .woocommerce-grouped-product-list-item__price, body.woocommerce div.product .woocommerce-variation-price .price, body.woocommerce div.product p.price,
            body.woocommerce ul.products li.product .price,
            body .woocommerce ul.products li.product .price{
                color: %1$s;
            }
        ';
    }
    wp_add_inline_style('oceanica-style', sprintf($css, $main_text_color));
}

add_action('wp_enqueue_scripts', 'oceanica_main_text_color_css', 11);


/**
 * Enqueues front-end CSS for the link color.
 *
 * @since Oceanica 1.0
 *
 * @see wp_add_inline_style()
 */
function oceanica_brand_color_hover_css()
{
    $color_scheme = oceanica_get_color_scheme();
    $default_color = $color_scheme[3];
    $brand_color_hover = get_theme_mod('brand_color_hover', $default_color);

    // Don't do anything if the current color is the default.
    if ($brand_color_hover === $default_color) {
        return;
    }

    $css = '
	button:hover,
	.button:hover,
	button:focus,
	.button:focus,
	input[type="button"]:hover, 
	input[type="reset"]:hover, 
	input[type="submit"]:hover,
	input[type="button"]:focus, 
	input[type="reset"]:focus, 
	input[type="submit"]:focus,
	.entry-child-pages-list .more-link:hover,
	.entry-child-pages-list .more-link:focus{	
        border-color: %1$s;
		background-color: %1$s;
	}	
	';
    if (class_exists('WooCommerce')) {
        $css .= '
        body .woocommerce #respond input#submit.alt:hover, body .woocommerce a.button.alt:hover, body .woocommerce button.button.alt:hover, body .woocommerce input.button.alt:hover,
        body.woocommerce #respond input#submit.alt:hover, body.woocommerce a.button.alt:hover, body.woocommerce button.button.alt:hover, body.woocommerce input.button.alt:hover,
        body.woocommerce #respond input#submit:hover, body.woocommerce a.button:hover, body.woocommerce button.button:hover, body.woocommerce input.button:hover,
        body .woocommerce #respond input#submit:hover, body .woocommerce a.button:hover, body .woocommerce button.button:hover, body .woocommerce input.button:hover{
            background-color: %1$s;
        }
        body.woocommerce #respond input#submit:hover, body.woocommerce a.button:hover, body.woocommerce button.button:hover, body.woocommerce input.button:hover,
        body .woocommerce #respond input#submit:hover, body .woocommerce a.button:hover, body .woocommerce button.button:hover, body .woocommerce input.button:hover{
            border-color: %1$s;
        }
        ';
    }

    wp_add_inline_style('oceanica-style', sprintf($css, $brand_color_hover));
}

add_action('wp_enqueue_scripts', 'oceanica_brand_color_hover_css', 11);


/**
 * Binds the JS listener to make Customizer color_scheme control.
 *
 * Passes color scheme data as colorScheme global.
 *
 */
function oceanica_customize_control_js()
{
    wp_enqueue_script('color-scheme-control', get_template_directory_uri() . '/js/color-scheme-control.js', array(
        'customize-controls',
        'iris',
        'underscore',
        'wp-util'
    ), '20160816', true);
    wp_localize_script('color-scheme-control', 'colorScheme', oceanica_get_color_schemes());
}

add_action('customize_controls_enqueue_scripts', 'oceanica_customize_control_js');

/**
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 *
 */
function oceanica_customize_preview_js()
{
    wp_enqueue_script('oceanica-customize-preview', get_template_directory_uri() . '/js/customize-preview.js', array('customize-preview'), '20160816', true);
}

add_action('customize_preview_init', 'oceanica_customize_preview_js');