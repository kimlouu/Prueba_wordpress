<?php
/**
 * Author : Mateusz Grzybowski
 * grzybowski.mateuszz@gmail.com
 */


namespace BeforeAfter\MapManager;


class Activation {
    
    public function activationPlugin( $plugin )
    {
        if( 'osmapper_pro/osmapper_pro.php' === $plugin ){
            if( !is_plugin_active( 'osmapper/osmapper.php' ) ){
                wp_die( 'You should activate OSMapper first!' );
            }
        }
    }
    
    public function deactivationPlugin( $plugin )
    {
        //on normal plugin deactivation
        if( 'osmapper/osmapper.php' === $plugin ){
            if( is_plugin_active( 'osmapper_pro/osmapper_pro.php' ) ){
                wp_die( 'You should deactivate OSMapper Pro first!' );
            }
        }
    }
}