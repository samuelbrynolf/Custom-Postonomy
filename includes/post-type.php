<?php if (!function_exists('init_portfolio_custom_pt')){
	function init_portfolio_custom_pt() {
		$labels = array(
			'name'                => 'Portfolio',
			'singular_name'       => 'Portfolio',
			'menu_name'           => 'Portfolio',
			'parent_item_colon'   => 'Parent Item:',
			'all_items'           => 'All items',
			'view_item'           => 'View item',
			'add_new_item'        => 'Add new item to portfolio',
			'add_new'             => 'New item',
			'edit_item'           => 'Edit item',
			'update_item'         => 'Update item',
			'search_items'        => 'Search items',
			'not_found'           => 'Nothing found',
			'not_found_in_trash'  => 'Nothing found in thrash',
		);
		$args = array(
			'label'               => 'portfolio',
			'description'         => 'portfolio Description',
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields',),
			'taxonomies'          => array( 'objekttyp' ),
			'hierarchical'        => true,
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
		register_post_type( 'portfolio', $args );
	}
	add_action( 'init', 'init_portfolio_custom_pt', 0 );
	
	function post_type_tags_fix($request) { // Tags for custom post type? Yes please!
	  if ( isset($request['tag']) && !isset($request['post_type']) )
	  $request['post_type'] = 'any';
	  return $request;
	} 
	add_filter('request', 'post_type_tags_fix'); 
}