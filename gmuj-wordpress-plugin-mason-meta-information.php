<?php

/**
 * Plugin Name:       Mason WordPress: Mason Meta Information
 * Plugin URI:        https://github.com/jmacario-gmu/gmuj-wordpress-plugin-mason-meta-information
 * Description:       Mason WordPress plugin which implements the addition of Mason-related website meta information into the website's HTML meta tags.
 * Version:           0.0.1
 */

// Exit if this file is not called directly.
	if (!defined('WPINC')) {
		die;
	}

// Deprecated: Adds sub-level administrative menu link to WordPress admin menu (will appear as a menu item under settings)
function gmuj_mmi_add_sublevel_menu() {
	
	/*
	add_submenu_page(
		string   $parent_slug,
		string   $page_title,
		string   $menu_title,
		string   $capability,
		string   $menu_slug, 
		callable $function = ''
	);
	*/
	
	add_submenu_page(
		'options-general.php',
		'Mason Meta Information',
		'Mason Meta Information',
		'manage_options',
		'mason_meta',
		'gmuj_mmi_display_settings_page'
	);
	
}
//add_action( 'admin_menu', 'gmuj_mmi_add_sublevel_menu' );

// Adds top-level administrative menu link to WordPress admin menu
function gmuj_mmi_add_toplevel_menu() {

	/*
	add_menu_page(
		string   $page_title,
		string   $menu_title,
		string   $capability,
		string   $menu_slug,
		callable $function = '',
		string   $icon_url = '',
		int      $position = null
	)
	*/

	add_menu_page(
		'Mason Meta Information',
		'Mason Meta Information',
		'manage_options',
		'mason_meta',
		'gmuj_mmi_display_settings_page',
		'dashicons-admin-generic',
		1
	);

}
add_action( 'admin_menu', 'gmuj_mmi_add_toplevel_menu' );

// Displays the plugin settings page
function gmuj_mmi_display_settings_page() {
	
	// check if user is allowed access
	if (!current_user_can('manage_options')) return;

	// Begin HTML output
	echo "<div class='wrap'>";

	echo "<h1>" . esc_html(get_admin_page_title()) . "</h1>";
	echo "<form action='options.php' method='post'>";

	// output settings fields
	settings_fields('gmuj_mmi_options');

	// output setting sections
	do_settings_sections( 'gmuj_mmi' );

	// submit button
	submit_button();

	// Finish HTML output
	echo "</form>";
	echo "</div>";
	
}

// register plugin settings
function gmuj_mmi_register_settings() {
	
	/*
	Functions reference:

	register_setting( 
		string   $option_group, 
		string   $option_name, 
		callable $sanitize_callback = ''
	);

	add_settings_section( 
		string   $id, 
		string   $title, 
		callable $callback, 
		string   $page
	);

	add_settings_field(
    	string   $id, 
		string   $title, 
		callable $callback, 
		string   $page, 
		string   $section = 'default', 
		array    $args = []
	);
	*/

	// Register serialized options setting for this plugins options
	register_setting(
		'gmuj_mmi_options',
		'gmuj_mmi_options',
		'gmuj_mmi_callback_validate_options'
	);

	add_settings_section(
		'gmuj_mmi_section_settings_identity',
		'Website Identity',
		'gmuj_mmi_callback_section_settings_identity',
		'gmuj_mmi'
	);

	add_settings_field(
		'website_mason_unit',
		'Mason Unit',
		'gmuj_mmi_callback_field_text',
		'gmuj_mmi',
		'gmuj_mmi_section_settings_identity',
		['id' => 'website_mason_unit', 'label' => 'Mason unit']
	);
	
	add_settings_field(
		'website_mason_department',
		'Mason Department',
		'gmuj_mmi_callback_field_text',
		'gmuj_mmi',
		'gmuj_mmi_section_settings_identity',
		['id' => 'website_mason_department', 'label' => 'Mason department']
	);

	add_settings_section(
		'gmuj_mmi_section_settings_contacts',
		'Website Contacts',
		'gmuj_mmi_callback_section_settings_contacts',
		'gmuj_mmi'
	);
	
	add_settings_field(
		'website_contact_technical',
		'Website Technical Contact',
		'gmuj_mmi_callback_field_text',
		'gmuj_mmi',
		'gmuj_mmi_section_settings_contacts',
		['id' => 'website_contact_technical', 'label' => 'Technical contact Mason email address']
	);

	add_settings_field(
		'website_contact_content',
		'Website Content Contact',
		'gmuj_mmi_callback_field_text',
		'gmuj_mmi',
		'gmuj_mmi_section_settings_contacts',
		['id' => 'website_contact_content', 'label' => 'Content contact Mason email address']
	);

} 
add_action( 'admin_init', 'gmuj_mmi_register_settings' );

// callback: contacts settings section
function gmuj_mmi_callback_section_settings_contacts() {

	echo '<p>'. 'These settings enable you to customize the website contacts meta tags.' .'</p>';

}

// callback: identity settings section
function gmuj_mmi_callback_section_settings_identity() {

	echo '<p>'. 'These settings enable you to customize the website identity meta tags.' .'</p>';

}

// callback: text field
function gmuj_mmi_callback_field_text($args) {
	
	$options = get_option('gmuj_mmi_options', gmuj_mmi_options_default());
	
	$id    = isset($args['id'])    ? $args['id']    : '';
	$label = isset($args['label']) ? $args['label'] : '';
	
	$value = isset($options[$id]) ? sanitize_text_field($options[$id]) : '';
	
	echo '<input id="gmuj_mmi_options_'. $id .'" name="gmuj_mmi_options['. $id .']" type="text" size="40" value="'. $value .'"><br />';
	echo '<label for="gmuj_mmi_options_'. $id .'">'. $label .'</label>';
	
}

// Sets default plugin options
function gmuj_mmi_options_default() {

	return array(
		'website_contact_technical'   => '',
		'website_contact_content'   => '',
		'website_mason_unit'   => '',
		'website_mason_department'   => ''
	);

}

// callback: validate options
function gmuj_mmi_callback_validate_options($input) {
	
	// Mason unit
	if (isset($input['website_mason_unit'])) {
		$input['website_mason_unit'] = sanitize_text_field( $input['website_mason_unit'] );
	}
	// Mason department
	if (isset($input['website_mason_department'])) {
		$input['website_mason_department'] = sanitize_text_field( $input['website_mason_department'] );
	}

	// Technical contact field
	if (isset($input['website_contact_technical'])) {
		$input['website_contact_technical'] = sanitize_text_field( $input['website_contact_technical'] );
	}

	// Content contact field
	if (isset($input['website_contact_content'])) {
		$input['website_contact_content'] = sanitize_text_field( $input['website_contact_content'] );
	}

	return $input;
	
}

// output meta tags
function gmuj_mmi_add_meta_tags() {

	// Get plugin options
		$gmuj_mmi_options = get_option('gmuj_mmi_options', '');

	// Begin output
		echo PHP_EOL;
		echo "<!-- Mason Meta Information Plugin Output -->".PHP_EOL;

	// Output meta tags
		// Mason unit
		echo '<meta name="mason-unit" content="'.$gmuj_mmi_options['website_mason_unit'].'">'.PHP_EOL;
		// Mason department
		echo '<meta name="mason-department" content="'.$gmuj_mmi_options['website_mason_unit'].'">'.PHP_EOL;
		// Website technical contact
		echo '<meta name="website-technical-contact" content="'.$gmuj_mmi_options['website_contact_content'].'">'.PHP_EOL;

		// Website content contact
		echo '<meta name="website-content-contact" content="'.$gmuj_mmi_options['website_contact_technical'].'">'.PHP_EOL;

	// Finish output
		echo "<!-- End Mason Meta Information Plugin Output -->".PHP_EOL;

}
add_action('wp_head', 'gmuj_mmi_add_meta_tags', 99);