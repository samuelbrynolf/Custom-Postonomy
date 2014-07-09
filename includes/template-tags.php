<?php function sp_filter_portfolio(){
	global $wp;
	$current_url = home_url( $wp->request );
	$terms = get_terms( 'objekttyp' );

	echo '<ul id="js-list" class="m-list my_term-archive"><li><a class="tappilyTap m-filters__a s-is-appHome s-is-current" href="'.$current_url.'" data-role="#js-sample">Alla</a></li>';

		foreach ( $terms as $term ) {
	    $term = sanitize_term( $term, 'objekttyp' );
	    $term_link = get_term_link( $term, 'objekttyp' );
	    if ( is_wp_error( $term_link ) ) {
	        continue;
	    }
	    echo '<li><a class="tappilyTap m-filters__a" href="' . esc_url( $term_link ) . '" title="' . sprintf(__('Se alla objekt: %s', 'my_localization_domain'), $term->name) . '" data-role="#js-sample">' . $term->name . '</a></li>';
		}

	echo '</ul>'; 
}

function sp_loop_template($part){
	$args = array(
		'post_type' => 'portfolio',
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'posts_per_page' => '-1'
	);
	
	echo '<ul id="js-sample" class="l-span-A6 m-sample">';
	
		$portfolioitems = new WP_Query( $args );
		if( $portfolioitems->have_posts() ) {
		  while( $portfolioitems->have_posts() ) {
		  	$portfolioitems->the_post();
		    get_template_part($part);
		  }
		} else {
		  echo 'Inga objekt inlagda&hellip;';
		}
	echo '</ul>';
} ?>