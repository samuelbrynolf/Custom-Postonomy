<?php function scriptConditionals(){
	wp_enqueue_script('jquery');
	if(isset($optionsFilter['historyJS_disable']) == '1') {
		wp_enqueue_script('functionsMin');
	} else {
		wp_enqueue_script('bundled');
	}
} ?>