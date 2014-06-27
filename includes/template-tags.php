<?php function terms_as_nav(){
	//if (is_post_type_archive('portfolio')) {
		global $wp;
		$current_url = home_url( $wp->request );
	//}

	$args = array( 'hide_empty=0' );
	$terms = get_terms('type', $args);
	$count = count($terms); $i=0;

	if ($count > 0) {

		//if (is_post_type_archive('portfolio')) {
			$term_list = '<ul id="js-filters" class="m-filters"><li><a class="tappy m-filters__a s-is-appHome s-is-current" href="'.$current_url.'" data-role="#js-sample">Alla</a></li>';
		//} elseif (is_tax('objektsTyp')) {
		//	$term_list = '<ul id="js-filters" class="m-filters"><li><a class="tappy m-filters__a" href="'.get_bloginfo('url').'/portfolio">Alla</a></li>';
		//}

		foreach ($terms as $term) {
			$i++;
			$term_list .= '<li><a class="tappy m-filters__a" href="' . get_term_link( $term ) . '" title="' . sprintf(__('View all post filed under %s', 'my_localization_domain'), $term->name) . '" data-role="#js-sample">' . $term->name . '</a></li>';
			if ($count != $i) $term_list .= ''; else $term_list .= '</ul>';
		}

		echo $term_list;
	}
}

function loop_template($part){
	// http://9seeds.com/tech/including-templates-inside-a-plugin/
	// http://codex.wordpress.org/Plugin_API/Filter_Reference/template_include
	echo '<div id="js-sample">';
	if (is_post_type_archive('portfolio')) {
		echo 'test';
	}

	query_posts('showposts=-1');
	if (have_posts()) { while (have_posts()) { the_post();
			get_template_part($part);
		}}

	echo '</div>';
} ?>