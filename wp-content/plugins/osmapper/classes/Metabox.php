<?php
/**
 * Author : Mateusz Grzybowski
 * grzybowski.mateuszz@gmail.com
 */


namespace BeforeAfter\MapManager;


class Metabox {
    
    /**
     * @var string
     */
    protected $prefix;
    
    /**
     * Based on this config marker form is rendered
     * @var array
     */
    protected $markerConfig = [];
    
    /**
     *  Based on this config map for is renderd
     * @var array
     */
    protected $mainConfig = [];
    
    /**
     * @var bool
     */
    protected $is_valid;
    
    public function __construct()
    {
        /**
         * Plugin main prefix
         */
        $this->prefix = BAMAP_PREFIX;
        /**
         * Build config to pass it to form renderer
         */
        $this->initConfig();
        /**
         * Add metaboxes
         */
        $this->init();
        
        $this->is_valid = TRUE;
        
        
    }
    
    protected function initConfig()
    {
        
        
        $this->mainConfig = [
            [
                'type'        => 'radio',
                'name'        => 'layer',
                'label'       => __( 'Color Scheme', 'osmapper' ),
                'placeholder' => __( 'Color Scheme', 'osmapper' ),
                'options'     => $this->__getColorSchemes(),
            ],
            [
                'type'        => 'radio',
                'name'        => 'pin',
                'label'       => __( 'Map pin', 'osmapper' ),
                'placeholder' => __( 'Map pin', 'osmapper' ),
                'options'     => $this->__getMapPins(),
            ],
            [
                'type'        => 'radio',
                'name'        => 'marker_position',
                'label'       => __( 'Map offset', 'osmapper' ),
                'placeholder' => __( 'Map offset', 'osmapper' ),
                'class'       => '--without__input',
                'options'     => $this->__getMarkerPositions(),
            ],
            [
                'type'        => 'number',
                'name'        => 'map_zoom',
                'label'       => __( 'Map zoom', 'osmapper' ),
                'placeholder' => __( 'Map zoom', 'osmapper' ),
                'class'       => '--with_label',
                'default'     => '14',
                'options'     => [
                    'name'  => 'map_zoom',
                    'value' => '',
                ],
            ],
            [
                'type'        => 'radio',
                'name'        => 'zoom_on_scroll',
                'label'       => __( 'Zoom on scroll', 'osmapper' ),
                'placeholder' => __( 'Zoom on scroll', 'osmapper' ),
                'class'       => '--without__input',
                //                'options'     => [
                //                    [
                //                        'name'  => 'enable_zoom',
                //                        'value' => 'Yes',
                //                    ],
                //                    [
                //                        'name'  => 'enable_zoom',
                //                        'value' => 'No',
                //                    ],
                //                ],
                'options'     => $this->__getZoomOnScroll(),
            
            ],
            
            
            $this->__addMoreFields(),
        
        ];
        
        $this->markerConfig = [
            [
                'type'        => 'number',
                'name'        => 'latitude',
                'label'       => __( 'Latitude', 'osmapper' ),
                'placeholder' => __( 'latitude', 'osmapper' ),
                'scope'       => 'table',
                //                'attr'        => [
                //                    'readonly' => 'readonly',
                //                ],
            ],
            [
                'type'        => 'number',
                'name'        => 'longitude',
                'label'       => __( 'Longitude', 'osmapper' ),
                'placeholder' => __( 'longitude', 'osmapper' ),
                'scope'       => 'table',
                //                'attr'        => [
                //                    'readonly' => 'readonly',
                //                ],
            ],
            //
            [
                'type'        => 'text',
                'name'        => 'street',
                'label'       => __( 'Street name and number', 'osmapper' ),
                'placeholder' => __( 'Street name and number', 'osmapper' ),
                'scope'       => 'table',
                'class'       => 'col-1-3',
            ],
            
            [
                'type'        => 'text',
                'name'        => 'city',
                'label'       => __( 'City', 'osmapper' ),
                'placeholder' => __( 'City', 'osmapper' ),
                'scope'       => 'table',
                'class'       => 'col-1-3',
            ],
            [
                'type'        => 'text',
                'name'        => 'zip_code',
                'label'       => __( 'Zip code', 'osmapper' ),
                'placeholder' => __( 'Zip code', 'osmapper' ),
                'scope'       => 'table',
                'class'       => 'col-1-3',
            ],
            [
                'type'        => 'wysiwig',
                'name'        => 'infobox',
                'label'       => __( 'Popup information', 'osmapper' ),
                'placeholder' => __( 'it will be displayed after hover on map pin', 'osmapper' ),
                'scope'       => 'config',
                'class'       => 'col-1-1',
            ],
            [
                'type'        => 'hidden',
                'name'        => 'row_id',
                'label'       => __( 'row ID', 'osmapper' ),
                'placeholder' => __( 'row ID', 'osmapper' ),
                'scope'       => 'table',
                'class'       => 'col-1-1',
            ],
            
            //TODO: add zoom option
        
        ];
        
    }
    
    public function init()
    {
        //		$this->registerMetabox();
        /**
         * Adds metaboxes
         * DUH!
         */
        add_action( 'add_meta_boxes', [
            $this,
            'registerMetabox',
        ] );
        /**
         * Fires up only when BA_LOC_CPT is saving
         */
        add_action( 'save_post_'.BAMAP_CPT, [
            $this,
            'saveMetabox',
        ] );
        
    }
    
    /**
     *
     */
    public function registerMetabox()
    {
        global $pagenow;
        
        add_meta_box( 'ba_map_lat_long', __( 'Map localization', 'osmapper' ), [
            $this,
            'renderMetabox',
        ], BAMAP_CPT, 'normal', 'high' );
        
        add_meta_box( 'ba_map_config', __( 'Map config', 'osmapper' ), [
            $this,
            'renderConfig',
        ], BAMAP_CPT, 'normal', 'low' );
        
        add_meta_box( 'ba_map_shortcode', __( 'Map shortcode', 'osmapper' ), [
            $this,
            'renderShortcode',
        ], BAMAP_CPT, 'side', 'high' );
        
        /**
         * Disble render preview on post-new action
         */
        if( $pagenow !== 'post-new.php' ){
            add_meta_box( 'ba_map_preview', __( 'Map preview', 'osmapper' ), [
                $this,
                'renderPreview',
            ], BAMAP_CPT, 'normal', 'low' );
            
        }
        
        
    }
    
    /**
     * Renders a shortcode which can be used to renders a map
     *
     * @param $post
     */
    public function renderShortcode( $post )
    {
        echo '<p class="config_section__title">'.__( 'Shortcode to paste on page', 'osmapper' ).'</p>';
        echo '<input type="text" onfocus="this.select()" readonly="readonly" value=\'[osmapper id="'.$post->ID.'"]\' class="large-text" style="line-height: 1.7">';
        
        
    }
    
    /**
     * Renderd config options in side area of post
     *
     * In config we can change map color layer and markers pins
     *
     * @param $post
     */
    public function renderConfig( $post )
    {
        $formBuilder = new FormBuilder();
        $formBuilder->setState( $this->is_valid );
        
        $config = get_post_meta( $post->ID, $this->prefix.'config', TRUE );
        
        
        //        debug( $config );
        
        echo $formBuilder->__renderConfigItems( 'ba_map', $config, $this->mainConfig, 0 );
        
        
    }
    
    /**
     * Renders an preview of map with an option to change position of marker
     *
     * @param $post
     */
    public function renderPreview( $post )
    {
        
        
        echo '<p class="config_section__title">'.__( 'You can dragg markers to place them in right spot', 'osmapper' ).'</p>';
        echo do_shortcode( '[osmapper id="'.$post->ID.'"]' );
        
    }
    
    /**
     * Echo'es metabox fields
     *
     * @param $post
     */
    public function renderMetabox( $post )
    {
        $attributes = get_post_meta( $post->ID, $this->prefix.'attributes', TRUE );
        
        //        debug($attributes);
        
        $formBuilder = new FormBuilder();
        $formBuilder->setState( TRUE );
        
        
        ?>
		<div class="repeater">

		<div class="modernTable">
		<div class="tableHeader">
            <?php
            foreach( $this->markerConfig as $column ){
    
                if( $column[ 'scope' ] === 'table' ){
                    echo '<p class="'.$column[ 'type' ].'">'.$column[ 'label' ].'</p>';
                }
    
            }

            ?>
		</div>
		<div class="tableContent">
        <?php
        
        echo '<div id="ba_map_addresses" data-repeater-list="'.$this->prefix.'attributes'.'">';
        
        if( empty( $attributes ) ){
            echo $formBuilder->__renderRepeaterItems( 'ba_map', $attributes, $this->markerConfig, 0 );
            
        }
        else{
            
            echo $formBuilder->__renderRepeaterItems( 'ba_map', $attributes[ 0 ], $this->markerConfig, 0 );
        }
        
        
        echo '</div>';
        echo '</div>';//data-repeater-list
        echo '</div>'; //tableContent
        
        echo '<input class="ba-btn getCoords" type="button" value="'.__( 'Get coordinates', 'osmapper' ).'" />';
        
        echo '</div>'; //div.repeater
    }
    
    public function saveMetabox( $postID )
    {
        
        $map_atts = [];
        $map_config = [];
        
        $data = $_POST;
        
        foreach( $data as $valueName => $valueToSave ){
            /**
             * Search for ba_map__ prefix in $_POST array
             */
            if( strpos( $valueName, $this->prefix.'attributes' ) !== FALSE ){
                
                
                $debug = [];
                foreach( $valueToSave as $key => $values ){
                    
                    foreach( $values as $name => $value ){
                        
                        /**
                         * Saving infobox requires esc_textarea
                         */
                        if( $name === 'infobox' ){
                            $map_atts[ $key ][ sanitize_key( $name ) ] = wp_kses_post( $value );
                        }
                        else{
                            $map_atts[ $key ][ sanitize_key( $name ) ] = sanitize_text_field( $value );
                        }
                        /**
                         * Prevent of unseting row_id values
                         * It might be cause errors when it isnt set because we cant further mover pin
                         */
                        if( $name === 'row_id' AND !$value ){
                            $salt = wp_create_nonce( 'nonce_salt_'.$key );
                            $id = hash( 'crc32', $salt.$name );
                            
                            $map_atts[ $key ][ sanitize_key( $name ) ] = sanitize_text_field( $id );
                        }
                    }
                }
                //                wp_die( debug( $map_atts ) );
            }
            if( strpos( $valueName, $this->prefix.'config' ) !== FALSE ){
                
                /**
                 * Safe save strings
                 */
                foreach( $valueToSave as $key => $value ){
                    
                    if( $key === 'layer' || $key === 'pin' ){
                        /**
                         * pin and layer vales are URLs
                         */
                        $map_config[ sanitize_key( $key ) ] = esc_url( $value );
                    }
                    else{
                        $map_config[ sanitize_key( $key ) ] = sanitize_text_field( $value );
                    }
                }
            }
        }
        
        update_post_meta( $postID, $this->prefix.'attributes', $map_atts );
        update_post_meta( $postID, $this->prefix.'config', $map_config );
        
        
    }
    
    
    private function __getColorScheme( $name )
    {
        
        
        return $name;
    }
    
    /**
     *
     *
     *
     * @return array
     */
    protected function __addMoreFields()
    {
        return NULL;
    }
    
    /**
     * Renders aviable radio options with color schemes for map
     *
     * @return array
     */
    protected function __getColorSchemes()
    {
        return [
            [
                'name'  => 'scheme',
                'src'   => BAMAP_URL.'assets/images/schemes/light_all.png',
                'value' => '//basemaps.cartocdn.com/light_all/',
            ],
            [
                'name'  => 'scheme',
                'src'   => BAMAP_URL.'assets/images/schemes/voyager.png',
                'value' => '//basemaps.cartocdn.com/rastertiles/voyager/',
            ],
            [
                'name'  => 'scheme',
                'src'   => BAMAP_URL.'assets/images/schemes/pitney-bowes-dark.png',
                'value' => '//basemaps.cartocdn.com/dark_all/',
            ],
            [
                'name'  => 'scheme',
                'src'   => BAMAP_URL.'assets/images/schemes/spotify_dark.png',
                'value' => '//basemaps.cartocdn.com/spotify_dark/',
            ],
            
        ];
    }
    
    /**
     * Renders aviable radio options with color schemes for map
     *
     * @return array
     */
    protected function __getMapPins()
    {
        return [
            [
                'name'  => 'pin',
                'value' => BAMAP_URL.'assets/images/pins/pin-1.png',
                'src'   => BAMAP_URL.'assets/images/pins/pin-1.png',
            ],
            [
                'name'  => 'pin',
                'value' => BAMAP_URL.'assets/images/pins/pin-3.png',
                'src'   => BAMAP_URL.'assets/images/pins/pin-3.png',
            ],
        ];
    }
    
    protected function __getZoomOnScroll()
    {
        return [
            [
                'name'  => 'zoom_on_scroll',
                'value' => 'Yes',
            ],
            [
                'name'  => 'zoom_on_scroll',
                'value' => 'No',
            ],
        ];
    }
    
    protected function __getMarkerPositions()
    {
        return [
            [
                'name'  => 'map_position',
                'value' => 'center',
            ],
            [
                'name'  => 'map_position',
                'value' => 'bottom',
            ],
            [
                'name'  => 'map_position',
                'value' => 'left',
            ],
            [
                'name'  => 'map_position',
                'value' => 'right',
            ],
            [
                'name'  => 'map_position',
                'value' => 'top',
            ],
        ];
    }
}

