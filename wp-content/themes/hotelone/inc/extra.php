<?php
function hotelone_plugin_page_setup( $default_settings ) {
    $default_settings['parent_slug'] = 'themes.php';
    $default_settings['page_title']  = esc_html__( 'Hotelone Data' , 'hotelone' );
    $default_settings['menu_title']  = esc_html__( 'Import Demo Data' , 'hotelone' );
    $default_settings['capability']  = 'import';
    $default_settings['menu_slug']   = 'pt-one-click-demo-import';

    return $default_settings;
}
add_filter( 'pt-ocdi/plugin_page_setup', 'hotelone_plugin_page_setup' );

function hotelone_after_import_setup() {

    $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'primary' => $main_menu->term_id,
        )
    );

    $front_page_id = get_page_by_title( 'Home' );
    $blog_page_id  = get_page_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );
}
add_action( 'pt-ocdi/after_import', 'hotelone_after_import_setup' );

function hotelone_import_files() {
    return array(
        array(
            'import_file_name'           => 'Hotelone',
            'import_file_url'            =>'https://raw.githubusercontent.com/britetechs/Hotelone-demo-lite/111ab5bd4c05711a9057ce065069e455ec84cbcb/theme-content.xml',
            'import_widget_file_url'     =>'https://raw.githubusercontent.com/britetechs/Hotelone-demo-lite/master/theme-widget.wie',
            'import_customizer_file_url' =>'https://raw.githubusercontent.com/britetechs/Hotelone-demo-lite/master/theme-customizer.dat',
        
            'import_preview_image_url'   => get_template_directory_uri() . '/screenshot.png',
            'import_notice'              => __( 'Now click on the bottom button to import theme data, After you import this demo, Enjoy the theme.', 'hotelone' ),
            'preview_url'                => 'http://www.britetechs.com/',
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'hotelone_import_files' );

if ( ! function_exists( 'hotelone_get_layout' ) ) {
    function hotelone_get_layout( $default = 'right' ) {
        $layout = get_theme_mod( 'hotelone_layout', 'right' );
        return apply_filters( 'hotelone_get_layout', $layout, $default );
    }
}

if ( ! function_exists( 'hotelone_get_media_url' ) ) {
    function hotelone_get_media_url($media = array(), $size = 'full' )
    {
        $media = wp_parse_args( $media, array('url' => '', 'id' => ''));
        $url = '';
        if ($media['id'] != '') {
            if ( strpos( get_post_mime_type( $media['id'] ), 'image' ) !== false ) {
                $image = wp_get_attachment_image_src( $media['id'],  $size );
                if ( $image ){
                    $url = $image[0];
                }
            } else {
                $url = wp_get_attachment_url( $media['id'] );
            }
        }

        if ($url == '' && $media['url'] != '') {
            $id = attachment_url_to_postid( $media['url'] );
            if ( $id ) {
                if ( strpos( get_post_mime_type( $id ), 'image' ) !== false ) {
                    $image = wp_get_attachment_image_src( $id,  $size );
                    if ( $image ){
                        $url = $image[0];
                    }
                } else {
                    $url = wp_get_attachment_url( $id );
                }
            } else {
                $url = $media['url'];
            }
        }
        return $url;
    }
}


if ( ! function_exists( 'hotelone_custom_excerpt_length' ) ) :
/**
 * Custom excerpt length
 */
function hotelone_custom_excerpt_length( $length ) {
	
	if( is_admin() ){
		return $length;
	}
	return 30;
}
add_filter( 'excerpt_length', 'hotelone_custom_excerpt_length', 999 );
endif;


if ( ! function_exists( 'hotelone_new_excerpt_more' ) ) :
/**
 * Remove […]
 */
function hotelone_new_excerpt_more( $more ) {
	
	if( is_admin() ){
		return $more;
	}
	
	$textagign = 'center';	
	return sprintf(
		' ... <div class="text-'.esc_attr( $textagign ).'"><a class="more-link" href="%s">%1s <i class="fa fa-angle-double-right"></i></a></div>',
		esc_url( get_the_permalink() ),
		__('Read More','hotelone')
		);
}
add_filter('excerpt_more', 'hotelone_new_excerpt_more');
endif;