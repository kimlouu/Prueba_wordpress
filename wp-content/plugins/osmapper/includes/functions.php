<?php
/**
 * Author : Mateusz Grzybowski
 * grzybowski.mateuszz@gmail.com
 */

if( !function_exists( 'ba_map_manager_admin_enqueue_styles' ) ){
    
    /**
     * Adds scripts and styles in admin section
     */
    function ba_map_manager_admin_enqueue_styles( $hook )
    {
        
        if( get_current_screen()->post_type === BAMAP_CPT ){
            /**
             * Admin scripts thirdparty
             */
            wp_enqueue_script( 'leaflet', BAMAP_URL.'assets/js/min/osmapper_leaflet.js', [], BAMAP_VERSION, TRUE );
            wp_enqueue_script( 'ba_map_admin_repeater', BAMAP_URL.'assets/js/min/osmapper_repeater.js', [], BAMAP_VERSION, TRUE );
            wp_enqueue_script( 'iziToast', BAMAP_URL.'assets/js/min/osmapper_toast.js', [], BAMAP_VERSION, TRUE );
            
            /**
             *
             */
            wp_enqueue_script( 'ba_map_admin_renderer', BAMAP_URL.'assets/js/min/osmapper_renderer.js', [], BAMAP_VERSION, TRUE );
            //wp_enqueue_script( 'ba_map_admin_renderer', BAMAP_URL.'assets/js/ba_map_renderer.js', [], BAMAP_VERSION, TRUE );
            wp_enqueue_script( 'ba_map_admin_coords', BAMAP_URL.'assets/js/min/osmapper_geocoder.js', [], BAMAP_VERSION, TRUE );
            wp_enqueue_script( 'ba_map_admin_scripts', BAMAP_URL.'assets/js/min/osmapper_admin.js', [], BAMAP_VERSION, TRUE );
            /**
             * Admin styles
             */
            wp_enqueue_style( 'ba_map_admin_renderer', BAMAP_URL.'assets/css/ba_map_renderer.css', [], BAMAP_VERSION );
    
    
            wp_localize_script( 'ba_map_admin_renderer', 'ba_map_ajax', [
                'url'              => admin_url( 'admin-ajax.php' ),
                'gif'              => BAMAP_URL.'assets/images/loader.gif',
                'baloonMessage'    => __( 'You should save post after changes', 'osmapper' ),
                'noResultsMessage' => __( 'Could not find coordinates for given address. Check again given details or move manually pin', 'osmapper' ),
            ] );
        }
    
        wp_enqueue_style( 'ba_map_admin_styles', BAMAP_URL.'assets/css/ba_map_admin_styles.css', [], BAMAP_VERSION );
        wp_enqueue_script( 'osmapper_review', BAMAP_URL.'assets/js/min/osmapper_review.js', [], BAMAP_VERSION, TRUE );
    
    }
}

add_action( 'admin_enqueue_scripts', 'ba_map_manager_admin_enqueue_styles', 20 );

if( !function_exists( 'ba_map_manager_enqueue_styles' ) ){
    
    /**
     * Adds scripts and styles in front-end section
     */
    function ba_map_manager_enqueue_styles()
    {
        /**
         * Thirdparty
         */
        wp_enqueue_script( 'leaflet', BAMAP_URL.'assets/js/min/osmapper_leaflet.js', [], BAMAP_VERSION, TRUE );
        
        /**
         * Admin scripts
         */
        wp_enqueue_script( 'ba_map_admin_renderer', BAMAP_URL.'assets/js/min/osmapper_renderer.js', [], BAMAP_VERSION, TRUE );
        //wp_enqueue_script( 'ba_map_scripts', BAMAP_URL.'assets/js/ba_map_scripts.js', [], BAMAP_VERSION, TRUE );
        /**
         * Admin styles
         */
        wp_enqueue_style( 'ba_map_renderer', BAMAP_URL.'assets/css/ba_map_renderer.css', [], BAMAP_VERSION );
        //        wp_enqueue_style( 'ba_map_styles', BAMAP_URL.'assets/css/ba_map_styles.css', [], BAMAP_VERSION );
        
        
        wp_localize_script( 'ba_map_admin_renderer', 'ba_map_ajax', [
            'url'           => admin_url( 'admin-ajax.php' ),
            'gif'           => BAMAP_URL.'assets/images/loader.gif',
            'defaultConfig' => [
                'pin'    => BAMAP_URL.'assets/images/pins/pin-1.png',
                'scheme' => 'http://basemaps.cartocdn.com/light_all',
            ],
        ] );
        
    }
}

add_action( 'wp_enqueue_scripts', 'ba_map_manager_enqueue_styles', 20 );


if( !function_exists( 'debug' ) ){
    
    function debug( $item )
    {
        /**
         * If debug is on in wp-config.php
         */
        if( WP_DEBUG ){
            echo '<pre>';
            print_r( debug_backtrace()[ 1 ][ 'function' ].':<br/>' );
            print_r( $item );
            
            echo '</pre>';
        }
    }
    
}


