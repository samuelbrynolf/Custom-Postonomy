<?php function filters_fCPT(){
	$optionsTax = get_option('fCPT_plugin_tax_options');
	$taxName = $optionsTax['tax_name'] != '' ? $optionsTax['tax_name'] : 'division';
	$terms = get_terms($taxName);
	
	if(is_tax($taxName)){
		echo '<ul class="m-filters terms"><li class="m-filters__li"><a href="'.get_bloginfo('url').'/portfolio" >Alla</a></li>';
	} else {
		global $wp;
		$current_url = home_url($wp->request);
		echo '<ul class="m-filters terms"><li class="m-filters__li"><a class="m-filters__a s-is-appHome s-is-current" href="'.$current_url.'" data-role="#js-cptItems">Alla</a></li>';
	}
	foreach ($terms as $term){
		$term = sanitize_term($term, $taxName);
		$term_link = get_term_link($term, $taxName);
		if (is_wp_error($term_link)) {
			continue;
		}
		if(is_tax($taxName)){
			echo '<li class="m-filters__li"><a href="' . esc_url( $term_link ) . '" title="' . sprintf(__('Se alla objekt: %s', 'my_localization_domain'), $term->name) . '" data-role="#js-cptItems">' . $term->name . '</a></li>';
		} else {
			echo '<li class="m-filters__li"><a class="m-filters__a term" href="' . esc_url( $term_link ) . '" title="' . sprintf(__('Se alla objekt: %s', 'my_localization_domain'), $term->name) . '" data-role="#js-cptItems">' . $term->name . '</a></li>';
		}
	}
	echo '</ul>';
}

function loop_all_fCPT($templatePart = 'fCPT-item'){
	$optionsTax = get_option('fCPT_plugin_tax_options');
	$taxName = $optionsTax['tax_name'] != '' ? $optionsTax['tax_name'] : 'division';
	$optionsCpt = get_option('fCPT_plugin_cpt_options');
	$cptName = $optionsCpt['cpt_name'] != '' ? $optionsCpt['cpt_name'] : 'portfolio';
	$orderBy = isset($optionsCpt['hierarchical']) != '' ? 'menu_order' : 'date';
	$order = isset($optionsCpt['hierarchical']) != '' ? 'ASC' : 'DESC';
	
	if(is_tax($taxName)){
		global $query_string;
		$args = array(
			'orderby' => $orderBy,
			'order' => $order,
			'posts_per_page' => '-1'
		);
		
		echo '<ul id="js-cptItems" class="m-cptItems">';
		query_posts($query_string, $args);
		if (have_posts()) {
			while (have_posts()) { the_post();
				echo '<li>';
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
			'post_type' => $cptName,
			'orderby' => $orderBy,
			'order' => $order,
			'posts_per_page' => '-1'
		);
		echo '<ul id="js-cptItems" class="m-cptItems">';
		$cptItems = new WP_Query($args);
		if($cptItems->have_posts()){
			while($cptItems->have_posts()){
				$cptItems->the_post();
				echo '<li>';
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
