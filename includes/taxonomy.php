<?php if (!function_exists('init_portfolio_tax')){
	function init_portfolio_tax() {
		$optionsTax = get_option('fCPT_plugin_tax_options');
		$optionsCpt = get_option('fCPT_plugin_cpt_options');
		$labels = array(
			'name'                       => $optionsTax['tax_name'] != '' ? $optionsTax['tax_name'] : 'Divisions',
			'singular_name'              => $optionsTax['tax_name'] != '' ? $optionsTax['tax_name'] : 'Division',
			'menu_name'                  => $optionsTax['tax_name'] != '' ? $optionsTax['tax_name'] : 'Divisions',
			'all_items'                  => 'All '.($optionsTax['tax_name'] != '' ? $optionsTax['tax_name'] : 'Divisions'),
			'parent_item'                => 'Parent',
			'parent_item_colon'          => 'Parent '.($optionsTax['tax_name'] != '' ? $optionsTax['tax_name'] : 'Division'),
			'new_item_name'              => 'New '.($optionsTax['tax_name'] != '' ? $optionsTax['tax_name'] : 'Division'),
			'add_new_item'               => 'Add new term to '.($optionsTax['tax_name'] != '' ? $optionsTax['tax_name'] : 'Division'),
			'edit_item'                  => 'Edit '.($optionsTax['tax_name'] != '' ? $optionsTax['tax_name'] : 'Divisions'),
			'update_item'                => 'Update '.($optionsTax['tax_name'] != '' ? $optionsTax['tax_name'] : 'Divisions'),
			'separate_items_with_commas' => 'Separate '.($optionsTax['tax_name'] != '' ? $optionsTax['tax_name'] : 'Divisions'.' with commas'),
			'search_items'               => 'Search '.($optionsTax['tax_name'] != '' ? $optionsTax['tax_name'] : 'Divisions'),
			'add_or_remove_items'        => 'Add or remove '.($optionsTax['tax_name'] != '' ? $optionsTax['tax_name'] : 'Divisions'),
			'choose_from_most_used'      => 'Pick from most used '.($optionsTax['tax_name'] != '' ? $optionsTax['tax_name'] : 'Divisions'),
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
			'rewrite' => array('slug' => $optionsTax['slug_name'] != '' ? $optionsTax['slug_name'] : 'portfolio-divisions'),
			'query_var' => true
		);
		register_taxonomy($optionsTax['tax_name'] != '' ? $optionsTax['tax_name'] : 'division', array($optionsCpt['cpt_name'] != '' ? $optionsCpt['cpt_name'] : 'portfolio'), $args );
	}
	add_action( 'init', 'init_portfolio_tax', 0 );
}