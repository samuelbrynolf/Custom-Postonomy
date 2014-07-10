<?php function fCPT_initialize_theme_options() {

// Settings for Custom Post Type & Custom Taxonomy
// ========================================================================================================================

  add_settings_section(
	  'cpt_tax_register',         // ID used to identify this section and with which to register options
	  'Custom Post Type + Custom Taxonomy',                  // Title to be displayed on the administration page
	  'cpt_tax_register_descr', // Callback used to render the description of the section
	  'general'                           // Page on which to add this section of options
  );
  
// Fields ----------------------------------------------------------------------------------------------------------------
  
  add_settings_field( 
    'cpt_hierarchical',                      // ID used to identify the field throughout the theme
    'Order by menu',                           // The label to the left of the option interface element
    'cpt_hierarchical_callback',   // The name of the function responsible for rendering the option interface
    'general',                          // The page on which this option will be displayed
    'cpt_tax_register',         // The name of the section to which this field belongs
    array(                              // The array of arguments to pass to the callback. In this case, just a description.
    	'Checked = Order loop by menu order. Unchecked = order by date'
    )
	);
	
// Register --------------------------------------------------------------------------------------------------------------
	
	register_setting(
    'general',
    'cpt_hierarchical'
	);
	
// Options for fitlers (mostly script-handling as a result)
// ========================================================================================================================
	
	add_settings_section(
	  'cpt_filters',         // ID used to identify this section and with which to register options
	  'Filters',                  // Title to be displayed on the administration page
	  'cpt_filters_descr', // Callback used to render the description of the section
	  'general'                           // Page on which to add this section of options
  );
  
// Fields ----------------------------------------------------------------------------------------------------------------
  
  add_settings_field( 
    'cpt_filters_activate',                      // ID used to identify the field throughout the theme
    'Enable filters',                           // The label to the left of the option interface element
    'cpt_filters_activate_callback',   // The name of the function responsible for rendering the option interface
    'general',                          // The page on which this option will be displayed
    'cpt_filters',         // The name of the section to which this field belongs
    array(                              // The array of arguments to pass to the callback. In this case, just a description.
    	''
    )
	);
	
	add_settings_field( 
    'cpt_filters_history',                      // ID used to identify the field throughout the theme
    'Include History.js',                           // The label to the left of the option interface element
    'cpt_filters_history_callback',   // The name of the function responsible for rendering the option interface
    'general',                          // The page on which this option will be displayed
    'cpt_filters',         // The name of the section to which this field belongs
    array(                              // The array of arguments to pass to the callback. In this case, just a description.
    	'Uncheck = you are 100% sure history.js already included by theme or other plugins.'
    )
	);
	
	add_settings_field( 
    'cpt_filters_tappy',                      // ID used to identify the field throughout the theme
    'Include Tappy.js',                           // The label to the left of the option interface element
    'cpt_filters_tappy_callback',   // The name of the function responsible for rendering the option interface
    'general',                          // The page on which this option will be displayed
    'cpt_filters',         // The name of the section to which this field belongs
    array(                              // The array of arguments to pass to the callback. In this case, just a description.
    	'Uncheck = you are 100% sure Tappy is already included by theme or other plugins.'
    )
	);
	
	add_settings_field( 
    'cpt_filters_customCptArchive',                      // ID used to identify the field throughout the theme
    'Put scripts on archive-{custom-post-type-name}.php-template only',                           // The label to the left of the option interface element
    'cpt_customCptArchive_callback',   // The name of the function responsible for rendering the option interface
    'general',                          // The page on which this option will be displayed
    'cpt_filters',         // The name of the section to which this field belongs
    array(                              // The array of arguments to pass to the callback. In this case, just a description.
    	'No need for filter-scripts everywhere. Reference: http://codex.wordpress.org/Post_Type_Templates'
    )
	);
	
// Register --------------------------------------------------------------------------------------------------------------

	register_setting(
    'general',
    'cpt_filters_activate'
	);
	
	register_setting(
    'general',
    'cpt_filters_history'
	);
	
	register_setting(
    'general',
    'cpt_filters_tappy'
	);
	
	register_setting(
    'general',
    'cpt_filters_customCptArchive'
	);

} // end fCPT_initialize_theme_options



// Section descriptions
// ======================================================================================================================

function cpt_tax_register_descr() {
	echo '<p>Create your custom post type along with associated taxonomy, by naming them below.</p>';
} 

function cpt_filters_descr() {
	echo '<p>Use Custom Taxonomy Terms as filters for your Custom Post Type. <a href="note.to.helf.com/templatetags">Instructions</a></p>';
}



// Custom Post Type & Custom Taxonomy field callbacks
// ======================================================================================================================

function cpt_hierarchical_callback($args) {
	$html = '<input type="checkbox" id="cpt_hierarchical" name="cpt_hierarchical" value="1" ' . checked(1, get_option('cpt_hierarchical'), false) . '/>'; 
	$html .= '<label for="cpt_hierarchical"> '  . $args[0] . '</label>'; 
	echo $html;
} 



// Filters field callbacks 
// ======================================================================================================================

function cpt_filters_activate_callback($args) {
  $html = '<input type="checkbox" id="cpt_filters_activate" name="cpt_filters_activate" value="1" ' . checked(1, get_option('cpt_filters_activate'), false) . '/>'; 
  $html .= '<label for="cpt_hierarchical"> '  . $args[0] . '</label>'; 
  echo $html;
} 

// ---------------------------------------------------------------------------------------------

function cpt_filters_history_callback($args) {
  $html = '<input type="checkbox" id="cpt_filters_history" name="cpt_filters_history" value="1" ' . checked(1, get_option('cpt_filters_history'), false) . '/>'; 
  $html .= '<label for="cpt_hierarchical"> '  . $args[0] . '</label>'; 
  echo $html;    
} 

// ---------------------------------------------------------------------------------------------

function cpt_filters_tappy_callback($args) {
  $html = '<input type="checkbox" id="cpt_filters_tappy" name="cpt_filters_tappy" value="1" ' . checked(1, get_option('cpt_filters_tappy'), false) . '/>'; 
  $html .= '<label for="cpt_hierarchical"> '  . $args[0] . '</label>'; 
  echo $html;     
} 

// ---------------------------------------------------------------------------------------------

function cpt_customCptArchive_callback($args) {
  $html = '<input type="checkbox" id="cpt_filters_customCptArchive" name="cpt_filters_customCptArchive" value="1" ' . checked(1, get_option('cpt_filters_customCptArchive'), false) . '/>'; 
  $html .= '<label for="cpt_hierarchical"> '  . $args[0] . '</label>'; 
  echo $html;     
} 

function fCPT_plugin_menu() {
  add_plugins_page(
    'Filter CPT',           // The title to be displayed in the browser window for this page.
    'Filter CPT',           // The text to be displayed for this menu item
    'administrator',            // Which type of users can see this menu item
    'fCPT_plugin_options',   // The unique ID - that is, the slug - for this menu item
    'fCPT_plugin_display'    // The name of the function to call when rendering the page for this menu
  );
} 
add_action('admin_menu', 'fCPT_plugin_menu');

function fCPT_plugin_display() {
  $html = '<div class="wrap">';
	  $html .= '<h2>Filter Custom Post Type options</h2>';
	  $html .= '<p class="description">There are currently no options. This is just for demo purposes.</p>';
  $html .= '</div>';
  echo $html;  
} 

add_action('admin_init', 'fCPT_initialize_theme_options');

  
?>