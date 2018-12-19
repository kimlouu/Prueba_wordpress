<?php
/**
 * Author : Mateusz Grzybowski
 * grzybowski.mateuszz@gmail.com
 */


namespace BeforeAfter\MapManager;


class Install {
    
    
    public function __construct()
    {
        add_action( 'init', [
            $this,
            'createPostType',
        ] );
        
     
        
    }
    

    
    public function createPostType()
    {
        
        $mapCPTArgs = [
            'name'      => BAMAP_CPT,
            'translate' => [
                'single' => __( 'Map' ),
                'plural' => __( 'Maps' ),
            ],
            'args'      => [
                'menu_icon'     => 'dashicons-admin-site',
                'menu_position' => 99999,
            ],
        ];
        
        $mapCPT = new Posttype( $mapCPTArgs[ 'name' ], $mapCPTArgs[ 'translate' ], $mapCPTArgs[ 'args' ] );
        $mapCPT->register_posttype();
        
        
    }
    
}