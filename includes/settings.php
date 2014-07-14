<?php function fCPT_example_plugin_menu() {
	add_plugins_page(
		'fCPT Plugin',   
		'fCPT Plugin',    
		'manage_options', 
		'fCPT_plugin_options',  
		'fCPT_plugin_menu' 
	);
}
add_action('admin_menu', 'fCPT_example_plugin_menu');

function fCPT_plugin_menu($active_tab = '') { ?>
	<div class="wrap">
		<div id="icon-plugins" class="icon32"></div>
		<h2><?php _e('Configure fCPT-plugin', 'fCPT'); ?></h2>
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
			<a href="?page=fCPT_plugin_options&tab=cpt_options" class="nav-tab <?php echo $active_tab == 'cpt_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Custom Post Type', 'fCPT' ); ?></a>
			<a href="?page=fCPT_plugin_options&tab=tax_options" class="nav-tab <?php echo $active_tab == 'tax_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Custom Taxonomy', 'fCPT' ); ?></a>
			<a href="?page=fCPT_plugin_options&tab=filter_options" class="nav-tab <?php echo $active_tab == 'filter_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Filters', 'fCPT' ); ?></a>
		</h2>
		<form method="post" action="options.php">
		<?php if($active_tab == 'tax_options') {
			settings_fields('fCPT_plugin_tax_options');
			do_settings_sections('fCPT_plugin_tax_options');
		} elseif( $active_tab == 'cpt_options') {
			settings_fields('fCPT_plugin_cpt_options');
			do_settings_sections('fCPT_plugin_cpt_options');
		} else {
			settings_fields('fCPT_plugin_filter_options');
			do_settings_sections('fCPT_plugin_filter_options');
		} submit_button(); ?>
		</form>
	</div>
<?php }

// ------------------------------------------------------------------------------------------------------------------------------------------------

function fCPT_plugin_default_cpt_options() {
	$defaults = array(
		'cpt_name'  => 'portfolio',
	);
	return apply_filters( 'fCPT_plugin_default_cpt_options', $defaults );
}

// ------------------------------------------------------------------------------------------------------------------------------------------------

function fCPT_plugin_default_tax_options() {
	$defaults = array(
		'tax_name'  => 'division',
		'slug_name'  => 'portfolio-divisions',
		'hierarchical' => '0',
	);
	return apply_filters( 'fCPT_plugin_default_tax_options', $defaults );
}

// ------------------------------------------------------------------------------------------------------------------------------------------------

function fCPT_plugin_default_filter_options() {
	$defaults = array(
		'filters_enable' => '0',
		'cpt_template_only' => '0',
		'historyJS_disable' => '0',
	);
	return apply_filters( 'fCPT_plugin_default_filter_options', $defaults );
}

//------------------------------------------------------------------------------------------------------------------------------------------------
// INIT fCPT OPTIONS
// ==================================================================================================================================================
// CPT ------------------------------------------------------------------------------------------------------------------------------------------------

function fCPT_plugin_initialize_cpt_options() {
	if( false == get_option( 'fCPT_plugin_cpt_options' ) ) {
		add_option( 'fCPT_plugin_cpt_options', apply_filters( 'fCPT_plugin_default_cpt_options', fCPT_plugin_default_cpt_options() ) );
	}
	add_settings_section(
		'cpt_settings_section',   
		__( 'Create custom post type', 'fCPT' ),  
		'fCPT_cpt_options_callback',
		'fCPT_plugin_cpt_options'  
	);
	add_settings_field(
		'cpt_name',
		'Name',
		'fCPT_cptname_callback',
		'fCPT_plugin_cpt_options',
		'cpt_settings_section'
	);
	add_settings_field(
		'hierarchical',      // ID used to identify the field throughout the plugin
		__( 'Hierarchical', 'fCPT' ),       // The label to the left of the option interface element
		'fCPT_cptHierarchical_callback', // The name of the function responsible for rendering the option interface
		'fCPT_plugin_cpt_options', // The page on which this option will be displayed
		'cpt_settings_section',   // The name of the section to which this field belongs
		array(        // The array of arguments to pass to the callback. In this case, just a description.
			__( 'Order posts by menu. (Default: Order by date)', 'fCPT' ),
		)
	);
	register_setting(
		'fCPT_plugin_cpt_options',
		'fCPT_plugin_cpt_options',
		'validate_sanitize_input'
	);
}
add_action( 'admin_init', 'fCPT_plugin_initialize_cpt_options' );

// TAX ------------------------------------------------------------------------------------------------------------------------------------------------

function fCPT_plugin_initialize_tax_options() {
	if( false == get_option( 'fCPT_plugin_tax_options' ) ) {
		add_option( 'fCPT_plugin_tax_options', apply_filters( 'fCPT_plugin_default_tax_options', fCPT_plugin_default_tax_options() ) );
	} 
	add_settings_section(
		'tax_settings_section',   // ID used to identify this section and with which to register options
		__( 'Create custom taxonomy', 'fCPT' ),  // Title to be displayed on the administration page
		'fCPT_tax_options_callback', // Callback used to render the description of the section
		'fCPT_plugin_tax_options'  // Page on which to add this section of options
	);
	add_settings_field(
		'tax_name',      // ID used to identify the field throughout the plugin
		__( 'Name', 'fCPT' ),       // The label to the left of the option interface element
		'fCPT_taxname_callback', // The name of the function responsible for rendering the option interface
		'fCPT_plugin_tax_options', // The page on which this option will be displayed
		'tax_settings_section',   // The name of the section to which this field belongs
		array(        // The array of arguments to pass to the callback. In this case, just a description.
			__( '', 'fCPT' ),
		)
	);
	add_settings_field(
		'slug_name',      // ID used to identify the field throughout the plugin
		__( 'Custom slug', 'fCPT' ),       // The label to the left of the option interface element
		'fCPT_slugname_callback', // The name of the function responsible for rendering the option interface
		'fCPT_plugin_tax_options', // The page on which this option will be displayed
		'tax_settings_section',   // The name of the section to which this field belongs
		array(        // The array of arguments to pass to the callback. In this case, just a description.
			__( '', 'fCPT' ),
		)
	);
	register_setting(
		'fCPT_plugin_tax_options',
		'fCPT_plugin_tax_options',
		'validate_sanitize_input'
	);
}
add_action( 'admin_init', 'fCPT_plugin_initialize_tax_options' );

// FILTERS ------------------------------------------------------------------------------------------------------------------------------------------------

function fCPT_plugin_initialize_filter_options() {
	if( false == get_option( 'fCPT_plugin_filter_options' ) ) {
		add_option( 'fCPT_plugin_filter_options', apply_filters( 'fCPT_plugin_default_filter_options', fCPT_plugin_default_filter_options() ) );
	}
	add_settings_section(
		'filter_settings_section',
		__( 'Set up filters for a list of custom post types.', 'fCPT' ),
		'fCPT_filter_options_callback',
		'fCPT_plugin_filter_options'
	);
	add_settings_field(
		'filters_enable',
		__( 'Enable filters', 'fCPT' ),
		'fCPT_filtersEnable_callback',
		'fCPT_plugin_filter_options',
		'filter_settings_section',
		array(
			__('', 'fCPT'),
		)
	);
	add_settings_field(
		'cpt_template_only',
		__( 'Custom template only', 'fCPT' ),
		'fCPT_cptTemplateOnly_callback',
		'fCPT_plugin_filter_options',
		'filter_settings_section',
		array(
			__('Run filter-scripts on custom template only. <a href="http://codex.wordpress.org/Post_Type_Templates" title="Custom Post Type Templates">Reference.</a>', 'fCPT'),
		)
	);
	add_settings_field(
		'historyJS_disable',
		__( 'Disable History.js', 'fCPT' ),
		'fCPT_historyJSDisable_callback',
		'fCPT_plugin_filter_options',
		'filter_settings_section',
		array(
			__('<a href="https://github.com/browserstate/history.js/" title="History JS plugin">History.js</a> is already included (by theme or plugin)', 'fCPT'),
		)
	);
	register_setting(
		'fCPT_plugin_filter_options',
		'fCPT_plugin_filter_options'
	);
} 
add_action( 'admin_init', 'fCPT_plugin_initialize_filter_options' );

//------------------------------------------------------------------------------------------------------------------------------------------------
// SECTION CALLBACKS
// ==================================================================================================================================================

function fCPT_cpt_options_callback() {
	echo '<p>' . __( 'Create your custom post type by naming it. Hint: Theme-template to list all your cpt = archive-{your-cpt-name}.php &mdash; http://codex.wordpress.org/Post_Type_Templates', 'fCPT' ) . '</p>';
}

function fCPT_tax_options_callback() {
	echo '<p>' . __( 'Create a hierarchical custom taxonomy by naming it. It will be associated to your custom post type and behave like categories. Enter a custom slug (optional).', 'fCPT' ) . '</p>';
}

function fCPT_filter_options_callback() {
	echo '<p>' . __( 'Filter a list of custom post types by taxonomy terms. Used with <a href="">fCPT custom template tags.</a> This feature is optional.', 'fCPT' ) . '</p>';
}

//------------------------------------------------------------------------------------------------------------------------------------------------
// FIELD CALLBACKS
// ==================================================================================================================================================

// CPT ------------------------------------------------------------------------------------------------------------------------------------------------

function fCPT_cptname_callback() {
	$options = get_option( 'fCPT_plugin_cpt_options' );
	$cptName = '';
	if( isset( $options['cpt_name'] ) ) {
		$cptName = $options['cpt_name'];
	}
	echo '<input type="text" id="cpt_name" name="fCPT_plugin_cpt_options[cpt_name]" value="' . $cptName . '" />';
}

function fCPT_cptHierarchical_callback($args) {
	$options = get_option('fCPT_plugin_cpt_options');
	$html = '<input type="checkbox" id="hierarchical" name="fCPT_plugin_cpt_options[hierarchical]" value="1" ' . checked(1, isset($options['hierarchical']) ? $options['hierarchical'] : 0, false).'/>';
	$html .= '<label for="hierarchical">&nbsp;'  . $args[0] . '</label>';
	echo $html;
}

// TAX ------------------------------------------------------------------------------------------------------------------------------------------------

function fCPT_taxname_callback() {
	$options = get_option( 'fCPT_plugin_tax_options' );
	$taxName = '';
	if( isset( $options['tax_name'] ) ) {
		$taxName = $options['tax_name'];
	}
	echo '<input type="text" id="tax_name" name="fCPT_plugin_tax_options[tax_name]" value="' . $taxName . '" />';
}

function fCPT_slugname_callback() {
	$options = get_option( 'fCPT_plugin_tax_options' );
	$taxSlug = '';
	if( isset( $options['slug_name'] ) ) {
		$taxSlug = $options['slug_name'];
	}
	echo '<input type="text" id="slug_name" name="fCPT_plugin_tax_options[slug_name]" value="' . $taxSlug . '" />';
}

// FILTERS ------------------------------------------------------------------------------------------------------------------------------------------------

function fCPT_filtersEnable_callback($args) {
	$options = get_option('fCPT_plugin_filter_options');
	$html = '<input type="checkbox" id="filters_enable" name="fCPT_plugin_filter_options[filters_enable]" value="1" ' . checked(1, isset($options['filters_enable']) ? $options['filters_enable'] : 0, false) . '/>';
	$html .= '<label for="filters_enable">&nbsp;'  . $args[0] . '</label>';
	echo $html;
}

function fCPT_cptTemplateOnly_callback($args) {
	$options = get_option('fCPT_plugin_filter_options');
	$html = '<input type="checkbox" id="cpt_template_only" name="fCPT_plugin_filter_options[cpt_template_only]" value="1" ' . checked(1, isset( $options['cpt_template_only']) ? $options['cpt_template_only'] : 0, false) . '/>';
	$html .= '<label for="cpt_template_only">&nbsp;'  . $args[0] . '</label>';
	echo $html;
}

function fCPT_historyJSDisable_callback($args) {
	$options = get_option('fCPT_plugin_filter_options');
	$html = '<input type="checkbox" id="historyJS_disable" name="fCPT_plugin_filter_options[historyJS_disable]" value="1" ' . checked( 1, isset($options['historyJS_disable']) ? $options['historyJS_disable'] : 0, false) . '/>';
	$html .= '<label for="historyJS_disable">&nbsp;'  . $args[0] . '</label>';
	echo $html;
}

//------------------------------------------------------------------------------------------------------------------------------------------------
// VALIDATE & SANITIZE REGISTERS
// ==================================================================================================================================================

function validate_sanitize_input($input) {
  $output = array();
  foreach( $input as $key => $value ) {
     if( isset( $input[$key] ) ) {
     	$output[$key] = preg_replace('/[^A-Za-z0-9-]+/', '-', $input[ $key ] );   
  	}   
  }
  return apply_filters( 'sandbox_theme_validate_input_examples', $output, $input );
} ?>