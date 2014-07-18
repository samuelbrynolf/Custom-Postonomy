<?php
/*
Plugin Name: Filter Custom Post Types
Plugin URI: http:// http://note-to-helf.com/filterCPT
Description: Add a Custom Post Type + Taxanomy. Taxonomy terms are used to filter Custom Post Type. Uses Ajax & history.js. Fallback for non-js support: taxonomy-YOURNAME.php..
Author: Samuel Brynolf
Author URI: http://note-to-helf.com
Version: 0.1.0
*/

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)){
	die('Invalid URL');
}

class filterCPT {
	public function __construct(){
		add_action('plugins_loaded', array(&$this, 'constants'), 1);
		add_action('plugins_loaded', array(&$this, 'includes'), 2);
		add_action('plugins_loaded', array(&$this, 'scripts'),3);
	}

	public function constants(){
		define('fCPT_DIR', plugin_dir_path( __FILE__ ));
		define('fCPT_INCLUDES', fCPT_DIR . trailingslashit('includes'));
	}

	public function includes(){
		require_once(fCPT_INCLUDES . 'settings.php');
		require_once(fCPT_INCLUDES . 'post-type.php');
		require_once(fCPT_INCLUDES . 'taxonomy.php');
		require_once(fCPT_INCLUDES . 'template-tags.php');
		require_once(fCPT_INCLUDES . 'enqueue_conditionals.php');
	}

	public function scripts(){
		function fCPT_scripts(){
			wp_register_script('bundled', plugins_url( '/js/bundled.min.js', __FILE__ ), array('jquery'), ' ', TRUE );
			wp_register_script('functionsMin', plugins_url( '/js/functions.min.js', __FILE__ ), array('jquery'), ' ', TRUE );
			enqueue_conditionals();
		}

		if(get_filter_options_value('filters_enable') == '1'){
			add_action('wp_enqueue_scripts', 'fCPT_scripts');
		}
	}
}

new filterCPT();