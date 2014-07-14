<?php 
/* 
Plugin Name: Filter Custom Post Types
Plugin URI: http:// http://note-to-helf.com/filterCPT
Description: Add a Custom Post Type + Taxanomy. Taxonomy terms are used to filter Custom Post Type. Uses Ajax & history.js. Fallback for non-js support: taxonomy-YOURNAME.php.. 
Author: Samuel Brynolf
Author URI: http://note-to-helf.com
Version: 0.1.0
*/

if (basename($_SERVER['PHP_SELF']) == basename (__FILE__)){
	die('Invalid URL');
}

class filterCPT {

	public function __construct(){
		add_action('plugins_loaded', array(&$this, 'constants'), 1);
		add_action('plugins_loaded', array(&$this, 'includes'), 2);
		add_action('plugins_loaded', array(&$this, 'scripts'),3);
	}

	public function constants() {
		define('fCPT_DIR', plugin_dir_path( __FILE__ ));
		define('fCPT_INCLUDES', fCPT_DIR . trailingslashit('includes'));
	}
	
	public function includes() {
		require_once(fCPT_INCLUDES . 'settings.php');
		require_once(fCPT_INCLUDES . 'post-type.php');
		require_once(fCPT_INCLUDES . 'taxonomy.php');
		require_once(fCPT_INCLUDES . 'template-tags.php');
	}
	
	public function scripts() {
		$optionsFilter = get_option('fCPT_plugin_filter_options'); 
		
		function fCPT_scripts(){
			wp_register_script( 'bundled', plugins_url( '/js/bundled.min.js', __FILE__ ), array('jquery'), ' ', TRUE );
			wp_register_script( 'functionsMin', plugins_url( '/js/functions.min.js', __FILE__ ), array('jquery'), ' ', TRUE );
			
			$optionsFilter = get_option('fCPT_plugin_filter_options');
			$optionsCpt = get_option('fCPT_plugin_cpt_options');
			$cptName = $optionsCpt['cpt_name'] != '' ? $optionsCpt['cpt_name'] : 'portfolio';
	    
	    //if(isset($optionsFilter['cpt_template_only']) && intval($optionsFilter['cpt_template_only'])) {
	    if(isset($optionsFilter['cpt_template_only']) == '1') {
	    	if(is_post_type_archive($cptName)) {
	    		echo 'Kör ut jQuery<br/>';
	    		wp_enqueue_script('jquery');
	    		//if(isset($optionsFilter['historyJS_disable']) && intval($optionsFilter['historyJS_disable'])) {
	    		if(isset($optionsFilter['historyJS_disable']) == '1') {
	    			wp_enqueue_script('functionsMin');
	    			echo 'filters enabled<br/>';
	   				echo 'är archive-prots.php msut have<br/>';
	   				echo 'disable history.js kör bara ut functions.min.js';
	    		} else {
	    			wp_enqueue_script('bundled');
	    			echo 'filters enabled<br/>';
	   				echo 'är archive-prots.php msut have<br/>';
	   				echo 'history.js aktivt — kör ut bundled.js<br/>';
	    		}
	    	} 
    	} else {
    		wp_enqueue_script('jquery');
    		echo 'kör jquery<br/>';
   			echo 'filters enabled<br/>';
    		echo 'är inte archive-prots.php must have<br/>';
    		//if(isset($optionsFilter['historyJS_disable']) && intval($optionsFilter['historyJS_disable'])) {
    			if(isset($optionsFilter['historyJS_disable']) == '1') {
    			wp_enqueue_script('functionsMin');
    			echo 'history.js disabled — kör functions.min.js istället<br/>';
    		} else {
    			wp_enqueue_script('bundled');
    			echo 'history.js aktivt — kör bundled.js<br/>';
    		} 
   		}
		}
		
		//if(isset($optionsFilter['filters_enable']) && intval($optionsFilter['filters_enable'])) {
		if(isset($optionsFilter['filters_enable']) == '1') {
			add_action('wp_enqueue_scripts', 'fCPT_scripts');
		}
	}
}

new filterCPT();