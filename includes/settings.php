<?php function cPostonomy_example_plugin_menu() {
	add_plugins_page(
		'Custom Postonomy',
		'Custom Postonomy',
		'manage_options',
		'cPostonomy_plugin_options',
		'cPostonomy_plugin_menu'
	);
}
add_action('admin_menu', 'cPostonomy_example_plugin_menu');

function cPostonomy_plugin_menu($active_tab = '') { ?>
	<div class="wrap">
		<div id="icon-plugins" class="icon32"></div>
		<h2><?php _e('Configure Custom Postonomy', 'cPostonomy'); ?></h2>
		<?php settings_errors(); ?>
		<?php if(isset($_GET['tab'])) {
		$active_tab = $_GET[ 'tab' ];
	} else if($active_tab == 'cpt_options') {
			$active_tab = 'tax_options';
		} else if($active_tab == 'filter_options') {
			$active_tab = 'filter_options';
		} else {
		$active_tab = 'cpt_options';
	} ?>
		<h2 class="nav-tab-wrapper">
			<a href="?page=cPostonomy_plugin_options&tab=cpt_options" class="nav-tab <?php echo $active_tab == 'cpt_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Custom Post Type', 'cPostonomy' ); ?></a>
			<a href="?page=cPostonomy_plugin_options&tab=tax_options" class="nav-tab <?php echo $active_tab == 'tax_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Custom Taxonomy', 'cPostonomy' ); ?></a>
			<a href="?page=cPostonomy_plugin_options&tab=filter_options" class="nav-tab <?php echo $active_tab == 'filter_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Filters', 'cPostonomy' ); ?></a>
		</h2>
		<form method="post" action="options.php">
		<?php if($active_tab == 'tax_options') {
		settings_fields('cPostonomy_plugin_tax_options');
		do_settings_sections('cPostonomy_plugin_tax_options');
	} elseif( $active_tab == 'cpt_options') {
		settings_fields('cPostonomy_plugin_cpt_options');
		do_settings_sections('cPostonomy_plugin_cpt_options');
	} else {
		settings_fields('cPostonomy_plugin_filter_options');
		do_settings_sections('cPostonomy_plugin_filter_options');
	} submit_button(); ?>
		</form>
	</div>
<?php }

// ------------------------------------------------------------------------------------------------------------------------------------------------

function cPostonomy_plugin_default_cpt_options() {
	$defaults = array(
		'cpt_name'  => 'Portfolio',
	);
	return apply_filters( 'cPostonomy_plugin_default_cpt_options', $defaults );
}

// ------------------------------------------------------------------------------------------------------------------------------------------------

function cPostonomy_plugin_default_tax_options() {
	$defaults = array(
		'tax_name'  => 'sections',
		'slug_name'  => 'portfolio-sections',
		'hierarchical' => 0,
	);
	return apply_filters( 'cPostonomy_plugin_default_tax_options', $defaults );
}

// ------------------------------------------------------------------------------------------------------------------------------------------------

function cPostonomy_plugin_default_filter_options() {
	$defaults = array(
		'filters_enable' => 0,
		'cpt_template_only' => 0,
		'historyJS_disable' => 0,
	);
	return apply_filters( 'cPostonomy_plugin_default_filter_options', $defaults );
}

//------------------------------------------------------------------------------------------------------------------------------------------------
// INIT cPostonomy OPTIONS
// ==================================================================================================================================================
// CPT ------------------------------------------------------------------------------------------------------------------------------------------------

function cPostonomy_plugin_initialize_cpt_options() {
	if( false == get_option( 'cPostonomy_plugin_cpt_options' ) ) {
		add_option( 'cPostonomy_plugin_cpt_options', apply_filters( 'cPostonomy_plugin_default_cpt_options', cPostonomy_plugin_default_cpt_options() ) );
	}
	add_settings_section(
		'cpt_settings_section',
		__( '', 'cPostonomy' ),
		'cPostonomy_cpt_options_callback',
		'cPostonomy_plugin_cpt_options'
	);
	add_settings_field(
		'cpt_name',
		'Name',
		'cPostonomy_cptname_callback',
		'cPostonomy_plugin_cpt_options',
		'cpt_settings_section',
		array(        // The array of arguments to pass to the callback. In this case, just a description.
			__( 'Blank = "Portfolio"', 'cPostonomy' ),
		)
	);
	add_settings_field(
		'hierarchical',      // ID used to identify the field throughout the plugin
		__( 'Hierarchical', 'cPostonomy' ),       // The label to the left of the option interface element
		'cPostonomy_cptHierarchical_callback', // The name of the function responsible for rendering the option interface
		'cPostonomy_plugin_cpt_options', // The page on which this option will be displayed
		'cpt_settings_section',   // The name of the section to which this field belongs
		array(        // The array of arguments to pass to the callback. In this case, just a description.
			__( 'Default: Order by date', 'cPostonomy' ),
		)
	);
	register_setting(
		'cPostonomy_plugin_cpt_options',
		'cPostonomy_plugin_cpt_options',
		'validate_sanitize_input'
	);
}
add_action( 'admin_init', 'cPostonomy_plugin_initialize_cpt_options' );

// TAX ------------------------------------------------------------------------------------------------------------------------------------------------

function cPostonomy_plugin_initialize_tax_options() {
	if( false == get_option( 'cPostonomy_plugin_tax_options' ) ) {
		add_option( 'cPostonomy_plugin_tax_options', apply_filters( 'cPostonomy_plugin_default_tax_options', cPostonomy_plugin_default_tax_options() ) );
	}
	add_settings_section(
		'tax_settings_section',   // ID used to identify this section and with which to register options
		__( '', 'cPostonomy' ),  // Title to be displayed on the administration page
		'cPostonomy_tax_options_callback', // Callback used to render the description of the section
		'cPostonomy_plugin_tax_options'  // Page on which to add this section of options
	);
	add_settings_field(
		'tax_name',      // ID used to identify the field throughout the plugin
		__( 'Name', 'cPostonomy' ),       // The label to the left of the option interface element
		'cPostonomy_taxname_callback', // The name of the function responsible for rendering the option interface
		'cPostonomy_plugin_tax_options', // The page on which this option will be displayed
		'tax_settings_section',   // The name of the section to which this field belongs
		array(        // The array of arguments to pass to the callback. In this case, just a description.
			__( 'Blank = "Sections"', 'cPostonomy' ),
		)
	);
	add_settings_field(
		'slug_name',      // ID used to identify the field throughout the plugin
		__( 'Slug', 'cPostonomy' ),       // The label to the left of the option interface element
		'cPostonomy_slugname_callback', // The name of the function responsible for rendering the option interface
		'cPostonomy_plugin_tax_options', // The page on which this option will be displayed
		'tax_settings_section',   // The name of the section to which this field belongs
		array(        // The array of arguments to pass to the callback. In this case, just a description.
			__( 'Blank = "portfolio-sections"', 'cPostonomy' ),
		)
	);
	register_setting(
		'cPostonomy_plugin_tax_options',
		'cPostonomy_plugin_tax_options',
		'validate_sanitize_input'
	);
}
add_action( 'admin_init', 'cPostonomy_plugin_initialize_tax_options' );

// FILTERS ------------------------------------------------------------------------------------------------------------------------------------------------

function cPostonomy_plugin_initialize_filter_options() {
	if( false == get_option( 'cPostonomy_plugin_filter_options' ) ) {
		add_option( 'cPostonomy_plugin_filter_options', apply_filters( 'cPostonomy_plugin_default_filter_options', cPostonomy_plugin_default_filter_options() ) );
	}
	add_settings_section(
		'filter_settings_section',
		__( '', 'cPostonomy' ),
		'cPostonomy_filter_options_callback',
		'cPostonomy_plugin_filter_options'
	);
	add_settings_field(
		'filters_enable',
		__( 'Enable filters', 'cPostonomy' ),
		'cPostonomy_filtersEnable_callback',
		'cPostonomy_plugin_filter_options',
		'filter_settings_section',
		array(
			__('', 'cPostonomy'),
		)
	);
	add_settings_field(
		'cpt_template_only',
		__( 'Custom template only', 'cPostonomy' ),
		'cPostonomy_cptTemplateOnly_callback',
		'cPostonomy_plugin_filter_options',
		'filter_settings_section',
		array(
			__('Run filter-scripts on custom template only. <a href="http://codex.wordpress.org/Post_Type_Templates" title="Custom Post Type Templates">Reference.</a>', 'cPostonomy'),
		)
	);
	add_settings_field(
		'historyJS_disable',
		__( 'Disable History.js', 'cPostonomy' ),
		'cPostonomy_historyJSDisable_callback',
		'cPostonomy_plugin_filter_options',
		'filter_settings_section',
		array(
			__('<a href="https://github.com/browserstate/history.js/" title="History JS plugin">History.js</a> is already included (by theme or plugin)', 'cPostonomy'),
		)
	);
	register_setting(
		'cPostonomy_plugin_filter_options',
		'cPostonomy_plugin_filter_options'
	);
}
add_action( 'admin_init', 'cPostonomy_plugin_initialize_filter_options' );

//------------------------------------------------------------------------------------------------------------------------------------------------
// SECTION CALLBACKS
// ==================================================================================================================================================

function cPostonomy_cpt_options_callback() {
	echo '<p>' . __( '', 'cPostonomy' ) . '</p>';
}

function cPostonomy_tax_options_callback() {
	echo '<p>' . __( '', 'cPostonomy' ) . '</p>';
}

function cPostonomy_filter_options_callback() {
	echo '<p>' . __( 'Use taxonomy terms to filter posts. Used with <a href="http://note-to-helf.com/custom-postonomy#template-tags" target="_blank">custom template tags.</a> This feature is optional.', 'cPostonomy' ) . '</p>';
}

//------------------------------------------------------------------------------------------------------------------------------------------------
// FIELD CALLBACKS
// ==================================================================================================================================================

// CPT ------------------------------------------------------------------------------------------------------------------------------------------------

function cPostonomy_cptname_callback($args) {
	$options = get_option( 'cPostonomy_plugin_cpt_options' );
	$cptName = '';
	if(isset($options['cpt_name'])) {
		$cptName = $options['cpt_name'];
	}
	$html = '<input type="text" id="cpt_name" name="cPostonomy_plugin_cpt_options[cpt_name]" value="' . $cptName . '" />';
	$html .= '<label for="slug_name">&nbsp;'  . $args[0] . '</label>';
	echo $html;
}

function cPostonomy_cptHierarchical_callback($args) {
	$options = get_option('cPostonomy_plugin_cpt_options');
	$html = '<input type="checkbox" id="hierarchical" name="cPostonomy_plugin_cpt_options[hierarchical]" value="1" ' . checked(1, isset($options['hierarchical']) ? $options['hierarchical'] : 0, false).'/>';
	$html .= '<label for="hierarchical">&nbsp;'  . $args[0] . '</label>';
	echo $html;
}

// TAX ------------------------------------------------------------------------------------------------------------------------------------------------

function cPostonomy_taxname_callback($args) {
	$options = get_option( 'cPostonomy_plugin_tax_options' );
	$taxSlug = '';
	if(isset($options['tax_name'])) {
		$taxName = $options['tax_name'];
	}
	$html = '<input type="text" id="tax_name" name="cPostonomy_plugin_tax_options[tax_name]" value="' . $taxName . '" />';
	$html .= '<label for="tax_name">&nbsp;'  . $args[0] . '</label>';
	echo $html;
}

function cPostonomy_slugname_callback($args) {
	$options = get_option( 'cPostonomy_plugin_tax_options' );
	$taxName = '';
	if(isset($options['slug_name'])) {
		$taxSlug = $options['slug_name'];
	}
	$html = '<input type="text" id="slug_name" name="cPostonomy_plugin_tax_options[slug_name]" value="' . $taxSlug . '" />';
	$html .= '<label for="slug_name">&nbsp;'  . $args[0] . '</label>';
	echo $html;
}

// FILTERS ------------------------------------------------------------------------------------------------------------------------------------------------

function cPostonomy_filtersEnable_callback($args) {
	$options = get_option('cPostonomy_plugin_filter_options');
	$html = '<input type="checkbox" id="filters_enable" name="cPostonomy_plugin_filter_options[filters_enable]" value="1" ' . checked(1, isset($options['filters_enable']) ? $options['filters_enable'] : 0, false) . '/>';
	$html .= '<label for="filters_enable">&nbsp;'  . $args[0] . '</label>';
	echo $html;
}

function cPostonomy_cptTemplateOnly_callback($args) {
	$options = get_option('cPostonomy_plugin_filter_options');
	$html = '<input type="checkbox" id="cpt_template_only" name="cPostonomy_plugin_filter_options[cpt_template_only]" value="1" ' . checked(1, isset( $options['cpt_template_only']) ? $options['cpt_template_only'] : 0, false) . '/>';
	$html .= '<label for="cpt_template_only">&nbsp;'  . $args[0] . '</label>';
	echo $html;
}

function cPostonomy_historyJSDisable_callback($args) {
	$options = get_option('cPostonomy_plugin_filter_options');
	$html = '<input type="checkbox" id="historyJS_disable" name="cPostonomy_plugin_filter_options[historyJS_disable]" value="1" ' . checked( 1, isset($options['historyJS_disable']) ? $options['historyJS_disable'] : 0, false) . '/>';
	$html .= '<label for="historyJS_disable">&nbsp;'  . $args[0] . '</label>';
	echo $html;
}

//------------------------------------------------------------------------------------------------------------------------------------------------
// VALIDATE- & SANITIZE- + GET VALUE- FUNCTIONS
// ==================================================================================================================================================

function validate_sanitize_input($input) {
	$output = array();
	foreach($input as $key => $value){
		if(isset($input[$key])){
			$output[$key] = preg_replace('/[^A-Za-z0-9-]+/', '-', $input[ $key ] );
		}
	}
	return apply_filters('validate_sanitize_input', $output, $input);
}

function get_cpt_options_value($fieldID, $sanitize_key=''){
	$optionsCpt = get_option('cPostonomy_plugin_cpt_options');
	if($fieldID === 'cpt_name' && $sanitize_key === ''){
		$value = $optionsCpt[$fieldID] != '' ? $optionsCpt[$fieldID] : 'Portfolio';
	} elseif($fieldID === 'cpt_name' && $sanitize_key === 'sanitize_key') {
		$value = $optionsCpt[$fieldID] != '' ? sanitize_key($optionsCpt[$fieldID]) : 'portfolio';
	} else {
		$value = isset($optionsCpt['hierarchical']) && intval($optionsCpt['hierarchical']);
	}
	return $value;
}

function get_tax_options_value($fieldID, $sanitize_key=''){
	$optionsTax = get_option('cPostonomy_plugin_tax_options');
	if($fieldID === 'tax_name' && $sanitize_key === ''){
		$value = $optionsTax['tax_name'] != '' ? $optionsTax['tax_name'] : 'Sections';
	} elseif($fieldID === 'tax_name' && $sanitize_key === 'sanitize_key'){
		$value = $optionsTax[$fieldID] != '' ? sanitize_key($optionsTax[$fieldID]) : 'sections';
	} elseif ($fieldID === 'slug_name'){
		$value = $optionsTax['slug_name'] != '' ? sanitize_key($optionsTax['slug_name']) : 'portfolio-sections';
	}
	return $value;
}

function get_filter_options_value($fieldID){
	$optionsFilter = get_option('cPostonomy_plugin_filter_options');
	$value = isset($optionsFilter[$fieldID]) && intval($optionsFilter[$fieldID]);
	return $value;
}