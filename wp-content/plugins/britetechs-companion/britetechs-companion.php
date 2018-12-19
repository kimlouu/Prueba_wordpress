<?php
/*
Plugin Name: Britetechs Companion
Description: Enhances britetechs themes with additional functionality.
Version: 1.1
Author: Britetechs
Author URI: https://Britetechs.com
Text Domain: britetechs-companion
*/
if(!define('bc_plugin_url', plugin_dir_url( __FILE__ ))){
	define( 'bc_plugin_url', plugin_dir_url( __FILE__ ) );
}
if(!define('bc_plugin_dir', plugin_dir_path( __FILE__ ))){
	define( 'bc_plugin_dir', plugin_dir_path( __FILE__ ) );
}

if( !function_exists('bc_init') ){
	function bc_init(){
		 
		/* Retrive Current Theme Contents Here */
		$themedata = wp_get_theme();
		$mytheme = $themedata->name;
		$mytheme = strtolower( $mytheme );
		$mytheme = str_replace( ' ','-', $mytheme );
		
		if(file_exists("inc/$mytheme/init.php")){
			require("inc/$mytheme/init.php");
		}
	}
}
add_action( 'init', 'bc_init' );