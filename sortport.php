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
		require_once( SP_INCLUDES . 'template-tags.php' );
	}
	
	public function scripts_and_styles() {

		function sp_scripts_styles(){
			wp_register_style('sortport-style', plugins_url('/css/sp-style.css', __FILE__));
			wp_register_script('historyJS', plugins_url( '/js/jquery.history.js', __FILE__ ), array('jquery'), ' ', TRUE );
			wp_register_script('tappy', plugins_url( '/js/tappy.js', __FILE__ ), array('jquery'), ' ', TRUE );
	    wp_register_script('functions', plugins_url( '/js/functions.js', __FILE__ ), array('jquery'), ' ', TRUE );
	    //wp_register_script( 'functionsMin', plugins_url( '/js/functions.min.js', __FILE__ ), array('jquery'), ' ', TRUE );
	    //wp_register_script( 'bundled', plugins_url( '/js/bundled.min.js', __FILE__ ), array('jquery'), ' ', TRUE );
	    
	    if (is_post_type_archive('portfolio')) {
		    wp_enqueue_script('jquery' );
		   	wp_enqueue_style('sortport-style');
	    	wp_enqueue_script('historyJS');
	    	wp_enqueue_script('tappy');
	    	wp_enqueue_script('functions');
	    	//wp_enqueue_script('functionsMin');
	    	//wp_enqueue_script('bundled'); // Bundled version = compressed historyJS + functions. Already using history.js? Enqueue only functionsMin
	    }
		}
		add_action('wp_enqueue_scripts', 'sp_scripts_styles');
	}
}

new sortPort(); 

?>