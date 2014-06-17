<?php if ( ! function_exists('init_portfolio_custom_pt') ) {

	// Register Custom Post Type
	function init_portfolio_custom_pt() {
	
		$labels = array(
			'name'                => 'Portfolio',
			'singular_name'       => 'Portfolio',
			'menu_name'           => 'Portfolio',
			'parent_item_colon'   => 'Parent Item:',
			'all_items'           => 'Alla objekt',
			'view_item'           => 'Se objekt',
			'add_new_item'        => 'L&auml;gg till nytt portfolio-objekt',
			'add_new'             => 'L&auml;gg till',
			'edit_item'           => 'Redigera objekt',
			'update_item'         => 'Uppdatera objekt',
			'search_items'        => 'S&ouml;k objekt',
			'not_found'           => 'Inget funnet!',
			'not_found_in_trash'  => 'Inget funnet i soporna!',
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
	
	// Hook into the 'init' action
	add_action( 'init', 'init_portfolio_custom_pt', 0 );
	
	function post_type_tags_fix($request) {
	  if ( isset($request['tag']) && !isset($request['post_type']) )
	  $request['post_type'] = 'any';
	  return $request;
	} 
	
	add_filter('request', 'post_type_tags_fix');

} ?>