<?php 

function terms_as_nav(){
	if (is_post_type_archive('portfolio')) {
		global $wp;
		$current_url = home_url( $wp->request );
	}
	
	$args = array( 'hide_empty=0' );
	$terms = get_terms('type', $args);
	$count = count($terms); $i=0;
		
	if ($count > 0) {
	
		if (is_post_type_archive('portfolio')) {
			$term_list = '<ul id="js-list" class="m-list my_term-archive"><li><a class="tappilyTap m-list__filter s-is-current" href="'.$current_url.'" data-role="#js-content">Alla</a></li>';
		} elseif (is_tax('objektsTyp')) {
			$term_list = '<ul class="m-list my_term-archive"><li><a href="'.get_bloginfo('url').'/portfolio">Alla</a></li>';
		}
			
		foreach ($terms as $term) {
			$i++;
		  $term_list .= '<li><a class="tappilyTap m-list__filter" href="' . get_term_link( $term ) . '" title="' . sprintf(__('View all post filed under %s', 'my_localization_domain'), $term->name) . '" data-role="#js-term-content">' . $term->name . '</a></li>';
		  if ($count != $i) $term_list .= ''; else $term_list .= '</ul>';
		 }
		 
		 echo $term_list;
	}
}

function loop_page_template(){

}







	
	 