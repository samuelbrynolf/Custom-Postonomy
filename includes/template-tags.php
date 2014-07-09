<?php function filters_fCPT(){
	$terms = get_terms('division');
	if(is_tax('division')){
		echo '<ul class="m-filters terms"><li><a class="m-filters__a" href="'.get_bloginfo('url').'/portfolio" >Alla</a></li>';
	} else {
		global $wp;
		$current_url = home_url($wp->request);
		echo '<ul class="m-filters terms"><li><a class="m-filters__a s-is-appHome s-is-current" href="'.$current_url.'" data-role="#js-cptItems">Alla</a></li>';
	}
		foreach ($terms as $term){
	    $term = sanitize_term($term, 'division');
	    $term_link = get_term_link($term, 'division');
	    if (is_wp_error($term_link)) {
	        continue;
	    }
	    echo '<li><a class="m-filters__a" href="' . esc_url( $term_link ) . '" title="' . sprintf(__('Se alla objekt: %s', 'my_localization_domain'), $term->name) . '" data-role="#js-cptItems">' . $term->name . '</a></li>';
		}
	echo '</ul>'; 
}

function loop_all_fCPT($templatePart = 'fCPT-item'){
	if(is_tax('division')){
		global $query_string;
		echo '<ul id="js-cptItems" class="m-cptItems">';
			query_posts($query_string . '&orderby=menu_order&order=ASC&posts_per_page=-1');		
			if (have_posts()) { 
				while (have_posts()) { the_post();
					get_template_part($templatePart);
				}
			} else {
			  echo 'No items added yet.';
			}
			wp_reset_query();
		echo '</ul>';
	} else {	
		$args = array(
			'post_type' => 'portfolio',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'posts_per_page' => '-1'
		);	
		echo '<ul id="js-cptItems" class="m-cptItems">';
			$cptItems = new WP_Query($args);
			if($cptItems->have_posts()){
			  while($cptItems->have_posts()){
			  	$cptItems->the_post();
			    get_template_part($templatePart);
			  }
			} else {
			  echo 'No items added yet.';
			}
			wp_reset_postdata();
		echo '</ul>';
	}
}

