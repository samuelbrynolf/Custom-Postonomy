<?php if (!function_exists('init_portfolio_tax')){
	function init_portfolio_tax() {
		$labels = array(
			'name'                       => 'Portfolio division',
			'singular_name'              => 'Division',
			'menu_name'                  => 'Division',
			'all_items'                  => 'All divisions',
			'parent_item'                => 'Parent',
			'parent_item_colon'          => 'Parent division:',
			'new_item_name'              => 'New division',
			'add_new_item'               => 'Add division',
			'edit_item'                  => 'Edit division',
			'update_item'                => 'Update division',
			'separate_items_with_commas' => 'Separate divisions with commas',
			'search_items'               => 'Search divisions',
			'add_or_remove_items'        => 'Add or remove divisions',
			'choose_from_most_used'      => 'Pick from most used divisions',
			'not_found'                  => 'Nothing found!',
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			//'show_tagcloud'              => true,
			'rewrite' => array('slug' => 'portfolio-divisions'),
			'query_var' => true
		);
		register_taxonomy( 'division', array( 'portfolio' ), $args );
	}
	add_action( 'init', 'init_portfolio_tax', 0 );
}