<?php if (!function_exists('init_portfolio_tax')){
	function init_portfolio_tax() {
		$labels = array(
			'name'                       => get_tax_options_value('tax_name'),
			'menu_name'                  => get_tax_options_value('tax_name'),
			'all_items'                  => 'All terms',
			'parent_item'                => 'Parent',
			'parent_item_colon'          => 'Parent item',
			'new_item_name'              => 'New item',
			'add_new_item'               => 'Add new term to '.get_tax_options_value('tax_name', 'sanitize_key'),
			'search_items'               => 'Search '.get_tax_options_value('tax_name','sanitize_key'),
			'add_or_remove_items'        => 'Add or remove term',
			'not_found'                  => 'Nothing found!',
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'rewrite' => array('slug' => get_tax_options_value('slug_name', 'sanitize_key')),
			'query_var' => true
		);
		register_taxonomy(get_tax_options_value('tax_name', 'sanitize_key'), array(get_cpt_options_value('cpt_name', 'sanitize_key')), $args );
	}
	add_action( 'init', 'init_portfolio_tax', 0 );
}