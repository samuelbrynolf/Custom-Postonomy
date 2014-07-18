<?php function enqueue_conditionals(){
	function historyJS_conditional(){
		wp_enqueue_script('jquery');
		if(get_filter_options_value('historyJS_disable') == '1') {
			wp_enqueue_script('functionsMin');
		} else {
			wp_enqueue_script('bundled');
		}
	}
	if(get_filter_options_value('cpt_template_only')  == '1') {
		if(is_post_type_archive(get_cpt_options_value('cpt_name', 'sanitize_key'))) {
			historyJS_conditional();
		}
	} else {
		historyJS_conditional();
	}
}