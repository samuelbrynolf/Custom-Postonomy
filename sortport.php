<?php 
/* 
Plugin Name: Sort Port
Plugin URI: http:// http://note-to-helf.com/sortport
Description: Filtrera portfolio-objekt
Author: Samuel Brynolf
Author URI: http://note-to-helf.com
Version: 0.1.0
*/

if (basename($_SERVER['PHP_SELF']) == basename (__FILE__)){
	die('Invalid URL');
}

class sortPort {

	public function __construct(){
		add_action( 'plugins_loaded', array(&$this, 'constants'), 1);
		add_action( 'plugins_loaded', array(&$this, 'includes'), 2);
		add_action( 'plugins_loaded', array(&$this, 'scripts_and_styles'),3);
	}

	public function constants() {
		define( 'SP_DIR', plugin_dir_path( __FILE__ ));
		define( 'SP_INCLUDES', SP_DIR . trailingslashit('includes'));
	}
	
	public function includes() {
		require_once( SP_INCLUDES . 'post-type.php' );
		require_once( SP_INCLUDES . 'taxonomy.php' );
	}
	
	public function scripts_and_styles() {
		// http://wordpress.stackexchange.com/questions/99067/enqueue-scripts-inside-a-class-in-a-plugin
		function runScripts(){
	    wp_register_script( 'custom-script', plugins_url( '/js/scripts.js', __FILE__ ), array('jquery'), ' ', TRUE );
	    
	    //if(is-portfolio specifik template eller taxonomi specifik tempalte fšr JUST mina plugins --> ){
	    	 wp_enqueue_script('custom-script');
	    //}
	   
		}
		
		add_action('wp_enqueue_scripts', 'runScripts');
	}
	
}

new sortPort();

?>