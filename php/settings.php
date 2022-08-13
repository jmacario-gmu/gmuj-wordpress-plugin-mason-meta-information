<?php

/**
 * Summary: php file which sets up plugin settings
 */


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
