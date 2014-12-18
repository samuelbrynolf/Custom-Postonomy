<?php function cpt_query($query){
	$orderby = get_cpt_options_value('hierarchical') != '' ? 'menu_order' : 'date';
	$order = get_cpt_options_value('hierarchical') != '' ? 'ASC' : 'DESC';
	$paginate = get_filter_options_value('enable_pagination') != '' ? '' : '-1';
	
	if($query->is_main_query() && is_post_type_archive(get_cpt_options_value('cpt_name', 'sanitize_key')) || $query->is_main_query() && is_tax(get_tax_options_value('tax_name', 'sanitize_key'))){
			$query->set('orderby', $orderby);
			$query->set('order', $order);
			$query->set('posts_per_page', $paginate);
		}
	return $query;
}
add_action('pre_get_posts','cpt_query');

function posts_link_attributes() {
	global $wp_query;
	return 'id="js-nextPostsLink" data-role="#js-cptItems" data-id="nextPosts" data-stop="'.$wp_query->max_num_pages.'"';
}
add_filter('next_posts_link_attributes', 'posts_link_attributes');

function terms_cPostonomy(){
	$taxName = get_tax_options_value('tax_name', 'sanitize_key');
	$terms = get_terms($taxName);
	$filterClass = is_tax($taxName) ? 'm-terms__a' : 'm-terms__a filter';
	$filterDataRole = is_tax($taxName) ? '' : ' data-role="#js-cptItems"';

	if(is_tax($taxName)){
		echo '<ul class="m-terms"><li class="m-terms__li"><a class="m-terms__a" href="'.get_bloginfo('url').'/'.get_cpt_options_value('cpt_name', 'sanitize_key').'" >Alla</a></li>';
	} else {
		global $wp;
		echo '<ul id="js-filters" class="m-terms"><li class="m-terms__li"><a class="m-terms__a filter s-is-appHome s-is-current" href="'.get_bloginfo('url').'/'.get_cpt_options_value('cpt_name', 'sanitize_key').'" data-role="#js-cptItems">Alla</a></li>';
	} foreach ($terms as $term){
		$term = sanitize_term($term, $taxName);
		$term_link = get_term_link($term, $taxName);
		if (is_wp_error($term_link)) {
			continue;
		}
		echo '<li class="m-terms__li"><a class="'.$filterClass.'" href="' . esc_url( $term_link ) . '" title="' . sprintf(__('Se alla objekt: %s', 'my_localization_domain'), $term->name).'"'.$filterDataRole.'>' . $term->name . '</a></li>';
	}
	echo '</ul>';
}

function loop_part_cPostonomy($templatePart = 'cPostonomy-part'){
	if(have_posts()) {
		if(is_tax(get_tax_options_value('tax_name', 'sanitize_key'))){
			global $wp_query;
			$taxpageCount = ' data-taxstop="'.$wp_query->max_num_pages.'"';
		} else {
			$taxpageCount = '';
		}
		
		echo '<ul id="js-cptItems" class="m-cptItems"'.$taxpageCount.'>';
			while (have_posts()) { the_post();
				echo '<li class="m-cptItems__li">';
					get_template_part($templatePart);
				echo '</li>';
			}
		echo '</ul>';
	} else {
		echo '<p>No items added yet.</p>';
	}
}