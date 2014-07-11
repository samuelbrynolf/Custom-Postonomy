<?php

/**
 * This function introduces the plugin options into the 'Appearance' menu and into a top-level 
 * 'fCPT plugin' menu.
 */
function fCPT_example_plugin_menu() {

	add_plugins_page(
		'fCPT Plugin', 					// The title to be displayed in the browser window for this page.
		'fCPT Plugin',					// The text to be displayed for this menu item
		'manage_options',					// Which type of users can see this menu item
		'fCPT_plugin_options',			// The unique ID - that is, the slug - for this menu item
		'fCPT_plugin_menu'				// The name of the function to call when rendering this menu's page
	);
} // end fCPT_example_plugin_menu
add_action( 'admin_menu', 'fCPT_example_plugin_menu' );

/**
 * Renders a simple page to display for the plugin menu defined above.
 */
function fCPT_plugin_menu( $active_tab = '' ) {
?>
	<!-- Create a header in the default WordPress 'wrap' container -->
	<div class="wrap">
	
		<div id="icon-plugins" class="icon32"></div>
		<h2><?php _e( 'Configure fCPT-plugin', 'fCPT' ); ?></h2>
		<?php settings_errors(); ?>
		
		<?php if( isset( $_GET[ 'tab' ] ) ) {
			$active_tab = $_GET[ 'tab' ];
		} else if( $active_tab == 'cpt_options' ) {
			$active_tab = 'tax_options';
		} else if( $active_tab == 'filter_options' ) {
			$active_tab = 'filter_options';
		} else {
			$active_tab = 'cpt_options';
		} // end if/else ?>
		
		<h2 class="nav-tab-wrapper">
			<a href="?page=fCPT_plugin_options&tab=cpt_options" class="nav-tab <?php echo $active_tab == 'cpt_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Custom Post Type', 'fCPT' ); ?></a>
			<a href="?page=fCPT_plugin_options&tab=tax_options" class="nav-tab <?php echo $active_tab == 'tax_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Custom Taxonomy', 'fCPT' ); ?></a>
			<a href="?page=fCPT_plugin_options&tab=filter_options" class="nav-tab <?php echo $active_tab == 'filter_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Filters', 'fCPT' ); ?></a>
		</h2>
		
		<form method="post" action="options.php">
			<?php
			
				if( $active_tab == 'tax_options' ) {
				
					settings_fields( 'fCPT_plugin_tax_options' );
					do_settings_sections( 'fCPT_plugin_tax_options' );
					
				} elseif( $active_tab == 'cpt_options' ) {
				
					settings_fields( 'fCPT_plugin_cpt_options' );
					do_settings_sections( 'fCPT_plugin_cpt_options' );
					
				} else {
				
					settings_fields( 'fCPT_plugin_filter_options' );
					do_settings_sections( 'fCPT_plugin_filter_options' );
					
				} // end if/else
				
				submit_button();
			
			?>
		</form>
		
	</div><!-- /.wrap -->
<?php
} // end fCPT_plugin_menu

/* ------------------------------------------------------------------------ *
 * Setting Registration
 * ------------------------------------------------------------------------ */ 


/**
 * Provides default values for the cpt Options.
 */
function fCPT_plugin_default_cpt_options() {
	
	$defaults = array(
		'cpt_name'		=>	'',
	);
	
	return apply_filters( 'fCPT_plugin_default_cpt_options', $defaults );
	
} // end fCPT_plugin_default_cpt_options

/**
 * Provides default values for the Display Options.
 */
function fCPT_plugin_default_tax_options() {
	
	$defaults = array(
		'tax_name'		=>	'',
	);
	
	return apply_filters( 'fCPT_plugin_default_tax_options', $defaults );
	
} // end fCPT_plugin_default_tax_options

/**
 * Provides default values for the Input Options.
 */
function fCPT_plugin_default_filter_options() {
	
	$defaults = array(
		'filters'	=>	'',
	);
	
	return apply_filters( 'fCPT_plugin_default_filter_options', $defaults );
	
} // end fCPT_plugin_default_filter_options

/**
 * Initializes the plugin's display options page by registering the Sections,
 * Fields, and Settings.
 *
 * This function is registered with the 'admin_init' hook.
 */ 
 
// Init cpt options ------------------------
 
 function fCPT_plugin_initialize_cpt_options() {

	if( false == get_option( 'fCPT_plugin_cpt_options' ) ) {	
		add_option( 'fCPT_plugin_cpt_options', apply_filters( 'fCPT_plugin_default_cpt_options', fCPT_plugin_default_cpt_options() ) );
	} // end if
	
	add_settings_section(
		'cpt_settings_section',			// ID used to identify this section and with which to register options
		__( 'Create custom post type', 'fCPT' ),		// Title to be displayed on the administration page
		'fCPT_cpt_options_callback',	// Callback used to render the description of the section
		'fCPT_plugin_cpt_options'		// Page on which to add this section of options
	);
	
	add_settings_field(	
		'cpt_name',						
		'Name',							
		'fCPT_cptname_callback',	
		'fCPT_plugin_cpt_options',	
		'cpt_settings_section'			
	);
	
	register_setting(
		'fCPT_plugin_cpt_options',
		'fCPT_plugin_cpt_options',
		'fCPT_plugin_sanitize_cpt_options'
	);
	
} // end fCPT_plugin_initialize_cpt_options
add_action( 'admin_init', 'fCPT_plugin_initialize_cpt_options' );



// Init taxonomy options ------------------------

function fCPT_plugin_initialize_tax_options() {

	// If the plugin options don't exist, create them.
	if( false == get_option( 'fCPT_plugin_tax_options' ) ) {	
		add_option( 'fCPT_plugin_tax_options', apply_filters( 'fCPT_plugin_default_tax_options', fCPT_plugin_default_tax_options() ) );
	} // end if

	// First, we register a section. This is necessary since all future options must belong to a 
	add_settings_section(
		'tax_settings_section',			// ID used to identify this section and with which to register options
		__( 'Create custom taxonomy', 'fCPT' ),		// Title to be displayed on the administration page
		'fCPT_tax_options_callback',	// Callback used to render the description of the section
		'fCPT_plugin_tax_options'		// Page on which to add this section of options
	);
	
	// Next, we'll introduce the fields for toggling the visibility of content elements.
	add_settings_field(	
		'tax_name',						// ID used to identify the field throughout the plugin
		__( 'Header', 'fCPT' ),							// The label to the left of the option interface element
		'fCPT_taxname_callback',	// The name of the function responsible for rendering the option interface
		'fCPT_plugin_tax_options',	// The page on which this option will be displayed
		'tax_settings_section',			// The name of the section to which this field belongs
		array(								// The array of arguments to pass to the callback. In this case, just a description.
			__( 'Activate this setting to display the header.', 'fCPT' ),
		)
	);
	
	// Finally, we register the fields with WordPress
	register_setting(
		'fCPT_plugin_tax_options',
		'fCPT_plugin_tax_options'
	);
	
} // end fCPT_plugin_initialize_tax_options
add_action( 'admin_init', 'fCPT_plugin_initialize_tax_options' );



// Init filter options ------------------------

function fCPT_plugin_initialize_filter_options() {

	if( false == get_option( 'fCPT_plugin_filter_options' ) ) {	
		add_option( 'fCPT_plugin_filter_options', apply_filters( 'fCPT_plugin_default_filter_options', fCPT_plugin_default_filter_options() ) );
	} // end if

	add_settings_section(
		'filter_options_section',
		__( 'Set up filters for a list of custom post types.', 'fCPT' ),
		'fCPT_filter_options_callback',
		'fCPT_plugin_filter_options'
	);
	
	add_settings_field(
		'filters',
		__( 'Enable filters', 'fCPT' ),
		'fCPT_filters_callback',
		'fCPT_plugin_filter_options',
		'filter_options_section'
	);
	
	register_setting(
		'fCPT_plugin_filter_options',
		'fCPT_plugin_filter_options'
	);

} // end fCPT_plugin_initialize_filter_options
add_action( 'admin_init', 'fCPT_plugin_initialize_filter_options' );

/* ------------------------------------------------------------------------ *
 * Section Callbacks
 * ------------------------------------------------------------------------ */ 
 
function fCPT_cpt_options_callback() {
	echo '<p>' . __( 'Create your custom post type by naming it. Hint: Theme-template to list all your cpt will be archive-{your-cpt-name}.php &mdash; http://codex.wordpress.org/Post_Type_Templates', 'fCPT' ) . '</p>';
} // end fCPT_tax_options_callback


function fCPT_tax_options_callback() {
	echo '<p>' . __( 'Create a hierarchical custom taxonomy by naming it. It will be associated to your custom post type and behave like categories. Enter a custom slug (optional).', 'fCPT' ) . '</p>';
} // end fCPT_tax_options_callback

function fCPT_filter_options_callback() {
	echo '<p>' . __( 'Filter a list of custom post types by taxonomy terms. Used with <a href="">fCPT custom template tags.</a> This feature is optional.', 'fCPT' ) . '</p>';
} // end fCPT_tax_options_callback

/* ------------------------------------------------------------------------ *
 * Field Callbacks
 * ------------------------------------------------------------------------ */ 

/**
 * This function renders the interface elements for toggling the visibility of the header element.
 * 
 * It accepts an array or arguments and expects the first element in the array to be the description
 * to be displayed next to the checkbox.
 */
 
 function fCPT_cptname_callback() {
	
	// First, we read the cpt options collection
	$options = get_option( 'fCPT_plugin_cpt_options' );
	
	// Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
	$url = '';
	if( isset( $options['cpt_name'] ) ) {
		$url = esc_url( $options['cpt_name'] );
	} // end if
	
	// Render the output
	echo '<input type="text" id="cpt_name" name="fCPT_plugin_cpt_options[cpt_name]" value="' . $url . '" />';
	
} // end fCPT_cptname_callback


function fCPT_taxname_callback($args) {
	
	// First, we read the options collection
	$options = get_option('fCPT_plugin_tax_options');
	
	// Next, we update the name attribute to access this element's ID in the context of the display options array
	// We also access the tax_name element of the options collection in the call to the checked() helper function
	$html = '<input type="checkbox" id="tax_name" name="fCPT_plugin_tax_options[tax_name]" value="1" ' . checked( 1, isset( $options['tax_name'] ) ? $options['tax_name'] : 0, false ) . '/>'; 
	
	// Here, we'll take the first argument of the array and add it to a label next to the checkbox
	$html .= '<label for="tax_name">&nbsp;'  . $args[0] . '</label>'; 
	
	echo $html;
	
} // end fCPT_taxname_callback

function fCPT_filters_callback($args) {
	
	// First, we read the options collection
	$options = get_option('fCPT_plugin_filter_options');
	
	// Next, we update the name attribute to access this element's ID in the context of the display options array
	// We also access the tax_name element of the options collection in the call to the checked() helper function
	$html = '<input type="checkbox" id="filters" name="fCPT_plugin_filter_options[filters]" value="1" ' . checked( 1, isset( $options['filters'] ) ? $options['filters'] : 0, false ) . '/>'; 
	
	// Here, we'll take the first argument of the array and add it to a label next to the checkbox
	$html .= '<label for="filters">&nbsp;'  . $args[0] . '</label>'; 
	
	echo $html;
	
} // end fCPT_filters_callback


/* ------------------------------------------------------------------------ *
 * Setting Callbacks
 * ------------------------------------------------------------------------ */ 
 
/**
 * Sanitization callback for the cpt options. Since each of the cpt options are text inputs,
 * this function loops through the incoming option and strips all tags and slashes from the value
 * before serializing it.
 *	
 * @params	$input	The unsanitized collection of options.
 *
 * @returns			The collection of sanitized values.
 */
function fCPT_plugin_sanitize_cpt_options( $input ) {
	
	// Define the array for the updated options
	$output = array();

	// Loop through each of the options sanitizing the data
	foreach( $input as $key => $val ) {
	
		if( isset ( $input[$key] ) ) {
			$output[$key] = esc_url_raw( strip_tags( stripslashes( $input[$key] ) ) );
		} // end if	
	
	} // end foreach
	
	// Return the new collection
	return apply_filters( 'fCPT_plugin_sanitize_cpt_options', $output, $input );

} // end fCPT_plugin_sanitize_cpt_options

function fCPT_plugin_validate_filter_options( $input ) {

	// Create our array for storing the validated options
	$output = array();
	
	// Loop through each of the incoming options
	foreach( $input as $key => $value ) {
		
		// Check to see if the current option has a value. If so, process it.
		if( isset( $input[$key] ) ) {
		
			// Strip all HTML and PHP tags and properly handle quoted strings
			$output[$key] = strip_tags( stripslashes( $input[ $key ] ) );
			
		} // end if
		
	} // end foreach
	
	// Return the array processing any additional functions filtered by this action
	return apply_filters( 'fCPT_plugin_validate_filter_options', $output, $input );

} // end fCPT_plugin_validate_filter_options

?>
