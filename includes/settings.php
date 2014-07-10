<?php function fCPT_plugin_menu() {
  add_plugins_page(
    'Filter CPT',           // The title to be displayed in the browser window for this page.
    'Filter CPT',           // The text to be displayed for this menu item
    'administrator',            // Which type of users can see this menu item
    'fCPT_plugin_options',   // The unique ID - that is, the slug - for this menu item
    'fCPT_plugin_display_options'    // The name of the function to call when rendering the page for this menu
  );
} 
add_action('admin_menu', 'fCPT_plugin_menu');

function fCPT_plugin_display_options() { 
	?>
  <!-- Create a header in the default WordPress 'wrap' container -->
  <div class="wrap">

      <!-- Add the icon to the page -->
      <div id="icon-themes" class="icon32"></div>
      <h2>Sandbox Theme Options</h2>

      <!-- Make a call to the WordPress function for rendering errors when settings are saved. -->
      <?php settings_errors(); ?>

      <!-- Create the form that will be used to render our options -->
      
      <form method="post" action="options.php">
  			<?php settings_fields( 'fCPT_plugin_display_options' ); ?>
  			<?php do_settings_sections( 'fCPT_plugin_display_options' ); ?>         
  			<?php submit_button(); ?>
			</form>

  </div><!-- /.wrap -->
<?php
} 
add_action('admin_init', 'fCPT_initialize_theme_options');


function fCPT_initialize_theme_options() {
	if( false == get_option('fCPT_plugin_display_options')){  
    add_option( 'fCPT_plugin_display_options' );
	} 

// Settings for Custom Post Type & Custom Taxonomy
// ========================================================================================================================

  add_settings_section(
	  'cpt_tax_register',         // ID used to identify this section and with which to register options
	  'Display options',                  // Title to be displayed on the administration page
	  'cpt_tax_register_descr', // Callback used to render the description of the section
	  'fCPT_plugin_display_options'                           // Page on which to add this section of options
  );
  
// Fields ----------------------------------------------------------------------------------------------------------------
  
  add_settings_field( 
    'cpt_hierarchical',                      // ID used to identify the field throughout the theme
    'Order by menu',                           // The label to the left of the option interface element
    'cpt_hierarchical_callback',   // The name of the function responsible for rendering the option interface
    'fCPT_plugin_display_options',                          // The page on which this option will be displayed
    'cpt_tax_register',         // The name of the section to which this field belongs
    array(                              // The array of arguments to pass to the callback. In this case, just a description.
    	'Checked = Order loop by menu order. Unchecked = order by date'
    )
	);
  
  add_settings_field( 
    'cpt_filters_activate',                      // ID used to identify the field throughout the theme
    'Enable filters',                           // The label to the left of the option interface element
    'cpt_filters_activate_callback',   // The name of the function responsible for rendering the option interface
    'fCPT_plugin_display_options',                          // The page on which this option will be displayed
    'cpt_tax_register',         // The name of the section to which this field belongs
    array(                              // The array of arguments to pass to the callback. In this case, just a description.
    	''
    )
	);
	
	add_settings_field( 
    'cpt_filters_history',                      // ID used to identify the field throughout the theme
    'Include History.js',                           // The label to the left of the option interface element
    'cpt_filters_history_callback',   // The name of the function responsible for rendering the option interface
    'fCPT_plugin_display_options',                          // The page on which this option will be displayed
    'cpt_tax_register',         // The name of the section to which this field belongs
    array(                              // The array of arguments to pass to the callback. In this case, just a description.
    	'Uncheck = you are 100% sure history.js already included by theme or other plugins.'
    )
	);
	
	add_settings_field( 
    'cpt_filters_tappy',                      // ID used to identify the field throughout the theme
    'Include Tappy.js',                           // The label to the left of the option interface element
    'cpt_filters_tappy_callback',   // The name of the function responsible for rendering the option interface
    'fCPT_plugin_display_options',                          // The page on which this option will be displayed
    'cpt_tax_register',         // The name of the section to which this field belongs
    array(                              // The array of arguments to pass to the callback. In this case, just a description.
    	'Uncheck = you are 100% sure Tappy is already included by theme or other plugins.'
    )
	);
	
	add_settings_field( 
    'cpt_filters_customCptArchive',                      // ID used to identify the field throughout the theme
    'Put scripts on archive-{custom-post-type-name}.php-template ONLY',                           // The label to the left of the option interface element
    'cpt_customCptArchive_callback',   // The name of the function responsible for rendering the option interface
    'fCPT_plugin_display_options',                          // The page on which this option will be displayed
    'cpt_tax_register',         // The name of the section to which this field belongs
    array(                              // The array of arguments to pass to the callback. In this case, just a description.
    	'No need for filter-scripts everywhere? Check! (Reference: http://codex.wordpress.org/Post_Type_Templates)'
    )
	);

	register_setting(
    'fCPT_plugin_display_options',
    'fCPT_plugin_display_options'
	);

} // end fCPT_initialize_theme_options


// Section descriptions
// ======================================================================================================================

function cpt_tax_register_descr() {
	echo '<p>Create your custom post type along with associated taxonomy, by naming them below.</p>';
} 



// Field callbacks
// ======================================================================================================================

function cpt_hierarchical_callback($args) {
	$options = get_option('fCPT_plugin_display_options');
	$html = '<input type="checkbox" id="cpt_hierarchical" name="fCPT_plugin_display_options[cpt_hierarchical]" value="1" ' . checked(1, isset($options['cpt_hierarchical'])?$options['cpt_hierarchical']:false, false) . '/>'; 
	$html .= '<label for="cpt_hierarchical"> '  . $args[0] . '</label>'; 
	echo $html;
} 


function cpt_filters_activate_callback($args) {
	$options = get_option('fCPT_plugin_display_options');
  $html = '<input type="checkbox" id="cpt_filters_activate" name="fCPT_plugin_display_options[cpt_filters_activate]" value="1" ' . checked(1, $options['cpt_filters_activate'], false) . '/>'; 
  $html .= '<label for="cpt_hierarchical"> '  . $args[0] . '</label>'; 
  echo $html;
} 

// ---------------------------------------------------------------------------------------------

function cpt_filters_history_callback($args) {
	$options = get_option('fCPT_plugin_display_options');
  $html = '<input type="checkbox" id="cpt_filters_history" name="fCPT_plugin_display_options[cpt_filters_history]" value="1" ' . checked(1, $options['cpt_filters_history'], false) . '/>'; 
  $html .= '<label for="cpt_hierarchical"> '  . $args[0] . '</label>'; 
  echo $html;    
} 

// ---------------------------------------------------------------------------------------------

function cpt_filters_tappy_callback($args) {
	$options = get_option('fCPT_plugin_display_options');
  $html = '<input type="checkbox" id="cpt_filters_tappy" name="fCPT_plugin_display_options[cpt_filters_tappy]" value="1" ' . checked(1, $options['cpt_filters_tappy'], false) . '/>'; 
  $html .= '<label for="cpt_hierarchical"> '  . $args[0] . '</label>'; 
  echo $html;     
} 

// ---------------------------------------------------------------------------------------------

function cpt_customCptArchive_callback($args) {
	$options = get_option('fCPT_plugin_display_options');
  $html = '<input type="checkbox" id="cpt_filters_customCptArchive" name="fCPT_plugin_display_options[cpt_filters_customCptArchive]" value="1" ' . checked(1, $options['cpt_filters_customCptArchive'], false) . '/>'; 
  $html .= '<label for="cpt_hierarchical"> '  . $args[0] . '</label>'; 
  echo $html;     
} ?>