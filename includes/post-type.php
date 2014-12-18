<?php if (!function_exists('init_portfolio_custom_pt')){
	function init_portfolio_custom_pt() {
		$labels = array(
			'name'                => get_cpt_options_value('cpt_name'),
			'singular_name'       => get_cpt_options_value('cpt_name'),
			'menu_name'           => get_cpt_options_value('cpt_name'),
			'add_new_item'        => 'Add new item to '.get_cpt_options_value('cpt_name'),
		);
		$args = array(
			'label'               => get_cpt_options_value('cpt_name'),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields'),
			'hierarchical'        => get_cpt_options_value('hierarchical'),
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
		register_post_type(get_cpt_options_value('cpt_name', 'sanitize_key'), $args );
	}
	add_action( 'init', 'init_portfolio_custom_pt', 0 );

	function post_type_tags_fix($request) { // inlcude CPT's for tag-template-loop
		if ( isset($request['tag']) && !isset($request['post_type']) )
			$request['post_type'] = 'any';
		return $request;
	}
	add_filter('request', 'post_type_tags_fix');
}