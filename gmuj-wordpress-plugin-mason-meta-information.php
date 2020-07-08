<?php

/**
 * Main plugin file for the Mason WordPress: Mason Meta Information plugin
 */

/**
 * Plugin Name:       Mason WordPress: Mason Meta Information
 * Author:            Jan Macario
 * Plugin URI:        https://github.com/jmacario-gmu/gmuj-wordpress-plugin-mason-meta-information
 * Description:       Mason WordPress plugin which implements the addition of Mason-related website meta information into the website's HTML meta tags.
 * Version:           0.0.1
 */


// Exit if this file is not called directly.
	if (!defined('WPINC')) {
		die;
	}

/**
 * Adds link to plugin settings page to Wordpress admin menu as a top-level item
 */
add_action('admin_menu', 'gmuj_mmi_add_toplevel_menu');
function gmuj_mmi_add_toplevel_menu() {

	// Add Wordpress admin menu item for this plugin's settings
	/*
	Code example:
	add_menu_page(
		string   $page_title, // title of page
		string   $menu_title, // title of menu item
		string   $capability, // capability needed for user to access this menu item
		string   $menu_slug, // unique string used to identify the plugins settings page - use plugin name
		callable $function = '', // function that displays the plugin page
		string   $icon_url = '', // menu icon
		int      $position = null // position in menu sidebar - the lower the number the higher it will appear
	)
	*/
	add_menu_page(
		'Mason Meta Information',
		'Mason Meta Information',
		'manage_options',
		'gmuj_mmi',
		'gmuj_mmi_display_settings_page',
		'dashicons-admin-generic',
		1
	);

}

/**
 * Adds link to plugin settings page to Wordpress admin menu as a sub-menu item under settings
 */
add_action('admin_menu', 'gmuj_mmi_add_sublevel_menu');
function gmuj_mmi_add_sublevel_menu() {
	
	// Add Wordpress admin menu item under settings for this plugin's settings
	/*
	add_submenu_page(
		string   $parent_slug, // under which admin page should this sub-menu item appear
		string   $page_title, // title of admin page
		string   $menu_title, // title of menu item
		string   $capability, // capability needed for user to access this menu item
		string   $menu_slug, // unique string used to identify the plugins settings page - use plugin name
		callable $function = '', // function that displays the plugin page
		int 	$position // the position in the menu order this item should appear
	);
	*/
	add_submenu_page(
		'options-general.php',
		'Mason Meta Information',
		'Mason Meta Information',
		'manage_options',
		'gmuj_mmi',
		'gmuj_mmi_display_settings_page',
		0
	);
	
}

/**
 * Generates the plugin settings page
 */
function gmuj_mmi_display_settings_page() {
	
	// Only continue if this user has the 'manage options' capability
	if (!current_user_can('manage_options')) return;

	// Begin HTML output
	echo "<div class='wrap'>";

	// Page title
	echo "<h1>" . esc_html(get_admin_page_title()) . "</h1>";

	// Begin form
	echo "<form action='options.php' method='post'>";

	// output settings fields - outputs required security fields - parameter specifes name of settings group
	settings_fields('gmuj_mmi_options');

	// output setting sections - parameter specifies name of menu slug
	do_settings_sections('gmuj_mmi');

	// submit button
	submit_button();

	// Close form
	echo "</form>";

	// Finish HTML output
	echo "</div>";
	
}

/**
 * Register plugin settings
 */
add_action('admin_init', 'gmuj_mmi_register_settings');
function gmuj_mmi_register_settings() {
	
	/*
	Code reference:

	register_setting( 
		string   $option_group, // name of option group - should match the parameter used in the settings_fields function in the display_settings_page function
		string   $option_name, // name of the particular option
		callable $sanitize_callback = '' // function used to validate settings
	);

	add_settings_section( 
		string   $id, // section id
		string   $title, // title/heading of section
		callable $callback, // function that displays section
		string   $page // admin page (slug) on which this section should be displayed
	);

	add_settings_field(
    	string   $id, // setting id
		string   $title, // title of setting
		callable $callback, // outputs markup required to display the setting
		string   $page, // page on which setting should be displayed, same as menu slug of the menu item
		string   $section = 'default', // section id in which this setting is placed
		array    $args = [] // array the contains data to be passed to the callback function. by convention I pass back the setting id and label to make things easier
	);
	*/

	// Register serialized options setting to store this plugin's options
	register_setting(
		'gmuj_mmi_options',
		'gmuj_mmi_options',
		'gmuj_mmi_callback_validate_options'
	);

	// Add section: website identity
	add_settings_section(
		'gmuj_mmi_section_settings_identity',
		'Website Identity Information',
		'gmuj_mmi_callback_section_settings_identity',
		'gmuj_mmi'
	);

	// Add field: mason unit
	add_settings_field(
		'website_mason_unit',
		'Mason Unit',
		'gmuj_mmi_callback_field_text',
		'gmuj_mmi',
		'gmuj_mmi_section_settings_identity',
		['id' => 'website_mason_unit', 'label' => 'Mason unit']
	);

	// Add field: mason department
	add_settings_field(
		'website_mason_department',
		'Mason Department',
		'gmuj_mmi_callback_field_text',
		'gmuj_mmi',
		'gmuj_mmi_section_settings_identity',
		['id' => 'website_mason_department', 'label' => 'Mason department']
	);

	// Add section: website identity
	add_settings_section(
		'gmuj_mmi_section_settings_contacts',
		'Website Contacts',
		'gmuj_mmi_callback_section_settings_contacts',
		'gmuj_mmi'
	);

	// Add field: website technical contact
	add_settings_field(
		'website_contact_technical',
		'Website Technical Contact',
		'gmuj_mmi_callback_field_text',
		'gmuj_mmi',
		'gmuj_mmi_section_settings_contacts',
		['id' => 'website_contact_technical', 'label' => 'Technical contact Mason email address']
	);

	// Add field: website content contact
	add_settings_field(
		'website_contact_content',
		'Website Content Contact',
		'gmuj_mmi_callback_field_text',
		'gmuj_mmi',
		'gmuj_mmi_section_settings_contacts',
		['id' => 'website_contact_content', 'label' => 'Content contact Mason email address']
	);

} 

/**
 * Generates content for identity settings section
 */
function gmuj_mmi_callback_section_settings_identity() {

	echo '<p>Set the website identity meta tags.</p>';

}

/**
 * Generates content for contacts settings section
 */
function gmuj_mmi_callback_section_settings_contacts() {

	echo '<p>Set the website contacts meta tags.</p>';

}

/**
 * Generates text field for plugin settings option
 */
function gmuj_mmi_callback_field_text($args) {
	
	//Get array of options. If the specified option does not exist, get default options from a function
	$options = get_option('gmuj_mmi_options', gmuj_mmi_options_default());
	
	//Extract field id and label from arguments array
	$id    = isset($args['id'])    ? $args['id']    : '';
	$label = isset($args['label']) ? $args['label'] : '';
	
	//Get setting value
	$value = isset($options[$id]) ? sanitize_text_field($options[$id]) : '';
	
	//Output field markup
	echo '<input id="gmuj_mmi_options_'. $id .'" name="gmuj_mmi_options['. $id .']" type="text" size="40" value="'. $value .'">';
	echo "<br />";
	echo '<label for="gmuj_mmi_options_'. $id .'">'. $label .'</label>';
	
}

/**
 * Sets default plugin options
 */
function gmuj_mmi_options_default() {

	return array(
		'website_mason_unit'   => '',
		'website_mason_department'   => '',
		'website_contact_technical'   => '',
		'website_contact_content'   => ''
	);

}

/**
 * Validate plugin options
 */
function gmuj_mmi_callback_validate_options($input) {
	
	// Mason unit
	if (isset($input['website_mason_unit'])) {
		$input['website_mason_unit'] = sanitize_text_field($input['website_mason_unit']);
	}
	// Mason department
	if (isset($input['website_mason_department'])) {
		$input['website_mason_department'] = sanitize_text_field($input['website_mason_department']);
	}

	// Technical contact field
	if (isset($input['website_contact_technical'])) {
		$input['website_contact_technical'] = sanitize_text_field($input['website_contact_technical']);
	}

	// Content contact field
	if (isset($input['website_contact_content'])) {
		$input['website_contact_content'] = sanitize_text_field($input['website_contact_content']);
	}

	return $input;
	
}

/**
 * Outputs meta tags to web page HTML head section
 */
add_action('wp_head', 'gmuj_mmi_add_meta_tags', 99); // Giving it a priority of 99 means it is typically called last in the wp_head action, so these meta tags appear right before the closing head tag
function gmuj_mmi_add_meta_tags() {

	// Get plugin options
		$gmuj_mmi_options = get_option('gmuj_mmi_options');

	// Begin output
		echo PHP_EOL;
		echo "<!-- Mason Meta Information Plugin Output -->".PHP_EOL;

	// Output meta tags, if values are not empty
		// Mason unit
		if (!empty($gmuj_mmi_options['website_mason_unit'])) {
			echo '<meta name="mason-unit" content="'.$gmuj_mmi_options['website_mason_unit'].'">'.PHP_EOL;
		}
		// Mason department
		if (!empty($gmuj_mmi_options['website_mason_department'])) {
			echo '<meta name="mason-department" content="'.$gmuj_mmi_options['website_mason_department'].'">'.PHP_EOL;
		}
		// Website technical contact
		if (!empty($gmuj_mmi_options['website_contact_technical'])) {
			echo '<meta name="mason-website-technical-contact" content="'.$gmuj_mmi_options['website_contact_technical'].'">'.PHP_EOL;
		}
		// Website content contact
		if (!empty($gmuj_mmi_options['website_contact_content'])) {
			echo '<meta name="mason-website-content-contact" content="'.$gmuj_mmi_options['website_contact_content'].'">'.PHP_EOL;
		}

	// Finish output
		echo "<!-- End Mason Meta Information Plugin Output -->".PHP_EOL;

}
