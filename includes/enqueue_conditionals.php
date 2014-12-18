<?php function enqueue_conditionals(){
	function historyJS_conditional(){
		wp_enqueue_script('jquery');
		if(get_filter_options_value('historyJS_disable') == '1') {
			wp_enqueue_script('historyJS');
			wp_enqueue_script('tappy');
			wp_enqueue_script('functionsMin');
		} else {
			wp_enqueue_script('bundled');
		}
	}
	if(!is_tax(get_tax_options_value('tax_name', 'sanitize_key'))) {
		historyJS_conditional();
	}
}