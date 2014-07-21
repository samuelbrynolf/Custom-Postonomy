<?php
/*
Plugin Name: Custom Postonomy
Plugin URI: http://note-to-helf.com/custom-postonomy/
Description: Creates a custom post type along with an associated (hierarchal) custom taxonomy. Use ajax to filter posts by taxonomy term (optional). 
Author: Samuel Brynolf
Author URI: http://note-to-helf.com
Version: 0.1.0
*/

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)){
	die('Invalid URL');
}

class cPostonomy {
	public function __construct(){
		add_action('plugins_loaded', array(&$this, 'constants'), 1);
		add_action('plugins_loaded', array(&$this, 'includes'), 2);
		add_action('plugins_loaded', array(&$this, 'scripts'),3);
	}

	public function constants(){
		define('cPostonomy_DIR', plugin_dir_path( __FILE__ ));
		define('cPostonomy_INCLUDES', cPostonomy_DIR . trailingslashit('includes'));
	}

	public function includes(){
		require_once(cPostonomy_INCLUDES . 'settings.php');
		require_once(cPostonomy_INCLUDES . 'post-type.php');
		require_once(cPostonomy_INCLUDES . 'taxonomy.php');
		require_once(cPostonomy_INCLUDES . 'template-tags.php');
		require_once(cPostonomy_INCLUDES . 'enqueue_conditionals.php');
	}

	public function scripts(){
		function cPostonomy_scripts(){
			wp_register_script('bundled', plugins_url( '/js/bundled.min.js', __FILE__ ), array('jquery'), ' ', TRUE );
			wp_register_script('functionsMin', plugins_url( '/js/functions.min.js', __FILE__ ), array('jquery'), ' ', TRUE );
			enqueue_conditionals();
		}

		if(get_filter_options_value('filters_enable') == '1'){
			add_action('wp_enqueue_scripts', 'cPostonomy_scripts');
		}
	}
}

new cPostonomy();