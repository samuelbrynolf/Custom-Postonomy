<?php if (!function_exists('init_portfolio_custom_pt')){
	function init_portfolio_custom_pt() {
	$optionsCpt = get_option('fCPT_plugin_cpt_options');
	$optionsTax = get_option('fCPT_plugin_tax_options');
		$labels = array(
			'name'                => $optionsCpt['cpt_name'] != '' ? $optionsCpt['cpt_name'] : 'Portfolio',
			'singular_name'       => $optionsCpt['cpt_name'] != '' ? $optionsCpt['cpt_name'] : 'Portfolio',
			'menu_name'           => $optionsCpt['cpt_name'] != '' ? $optionsCpt['cpt_name'] : 'Portfolio',
			'add_new_item'        => 'Add new item to '.($optionsCpt['cpt_name'] != '' ? $optionsCpt['cpt_name'] : 'Portfolio'),
		);
		$args = array(
			'label'               => $optionsCpt['cpt_name'] != '' ? $optionsCpt['cpt_name'] : 'Portfolio',
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields'),
			'taxonomies'          => array($optionsTax['tax_name'] != '' ? $optionsTax['tax_name'] : 'Divisions'),
			'hierarchical'        => isset($optionsCpt['hierarchical']) && intval($optionsCpt['hierarchical']),
			//'hierarchical'        => $orderBy = $optionsCpt['hierarchical'] != '' ? 'true' : 'false',
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => false,
			'menu_position'       => 5,
			'menu_icon'           => '',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
			'taxonomies' => array('post_tag')
		);
		register_post_type( $optionsCpt['cpt_name'] != '' ? $optionsCpt['cpt_name'] : 'portfolio', $args );
	}
	add_action( 'init', 'init_portfolio_custom_pt', 0 );
	
	function post_type_tags_fix($request) {
	  if ( isset($request['tag']) && !isset($request['post_type']) )
	  $request['post_type'] = 'any';
	  return $request;
	} 
	add_filter('request', 'post_type_tags_fix'); 
}