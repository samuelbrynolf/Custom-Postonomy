<?php function terms_cPostonomy(){
	$taxName = get_tax_options_value('tax_name', 'sanitize_key');
	$terms = get_terms($taxName);

	if(is_tax($taxName)){
		echo '<ul class="m-terms"><li class="m-terms__li"><a class="m-terms__a" href="'.get_bloginfo('url').'/portfolio" >Alla</a></li>';
	} else {
		global $wp;
		$current_url = home_url($wp->request);
		echo '<ul id="js-filters" class="m-terms"><li class="m-terms__li"><a class="m-terms__a filter s-is-appHome s-is-current" href="'.$current_url.'" data-role="#js-cptItems">Alla</a></li>';
	}
	foreach ($terms as $term){
		$term = sanitize_term($term, $taxName);
		$term_link = get_term_link($term, $taxName);
		if (is_wp_error($term_link)) {
			continue;
		}
		if(is_tax($taxName)){
			echo '<li class="m-terms__li"><a class="m-terms__a" href="' . esc_url( $term_link ) . '" title="' . sprintf(__('Se alla objekt: %s', 'my_localization_domain'), $term->name) . '">' . $term->name . '</a></li>';
		} else {
			echo '<li class="m-terms__li"><a class="m-terms__a filter" href="' . esc_url( $term_link ) . '" title="' . sprintf(__('Se alla objekt: %s', 'my_localization_domain'), $term->name) . '" data-role="#js-cptItems">' . $term->name . '</a></li>';
		}
	}
	echo '</ul>';
}

function loop_part_cPostonomy($templatePart = 'cPostonomy-part'){
	$taxName = get_tax_options_value('tax_name', 'sanitize_key');
	$orderby = get_cpt_options_value('hierarchical') != '' ? 'menu_order' : 'date';
	$order = get_cpt_options_value('hierarchical') != '' ? 'ASC' : 'DESC';

	if(is_tax($taxName)){
		global $query_string;
		$customargs = array(
			'orderby' => $orderby,
			'order' => $order,
			'posts_per_page' => '-1'
		);
		$args = wp_parse_args($query_string, $customargs);

		echo '<ul id="js-cptItems" class="m-cptItems">';
		query_posts($args);
		if (have_posts()) {
			while (have_posts()) { the_post();
				echo '<li class="m-cptItems__li">';
				get_template_part($templatePart);
				echo '</li>';
			}
		} else {
			echo 'No items added yet.';
		}
		wp_reset_query();
		echo '</ul>';

	} else {
		$args = array(
			'post_type' => get_cpt_options_value('cpt_name', 'sanitize_key'),
			'orderby' => $orderby,
			'order' => $order,
			'posts_per_page' => '-1'
		);
		echo '<ul id="js-cptItems" class="m-cptItems">';
		$cptItems = new WP_Query($args);
		if($cptItems->have_posts()){
			while($cptItems->have_posts()){
				$cptItems->the_post();
				echo '<li class="m-cptItems__li">';
				get_template_part($templatePart);
				echo '</li>';
			}
		} else {
			echo 'No items added yet.';
		}
		wp_reset_postdata();
		echo '</ul>';
	}
}
